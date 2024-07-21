<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\OutboxEmails;
use App\Models\InboxEmails;
use App\Models\Keyword;
use App\Models\Category;
use Webklex\IMAP\Facades\Client;
use Exception;
use Illuminate\Http\Request;

class MailController extends Controller {
    /*
        this function fetch emails from your email,
        and store in database then show in table
    */
    public function showInbox()
    {   
        //for test receiving Emails and store in database   
        /*$emails = [
            ['from' => 'example11@gmail.com', 'subject' => 'Meeting Reminder', 'message' => 'Hello Message One - urgent Message'],
            ['from' => 'example22@gmail.com', 'subject' => 'Project Update', 'message' => 'Hello Message Tow - sale Message'],
            ['from' => 'example33@gmail.com', 'subject' => 'Invitation', 'message' => 'Hello Message Three - newsletter Message'],
            ['from' => 'example33@gmail.com', 'subject' => 'Invitation', 'message' => 'Hello Message Four with out keywords'],
        ];*/

        try {

            //IMAP connect
            $client = Client::account('gmail');
            $client->connect();

            //prepare messages
            $folder = $client->getFolder('INBOX');
            $emails = $folder->messages()->all()->get();

            //fetch messages from gmail
            foreach ($emails as $email) {
                $categoriesId = $this->getCategoryId($email);
                $categoriesName = $this->getCategoryName($categoriesId);
                InboxEmails::create([
                    'from' => $email['from'],
                    'subject' => $email['subject'],
                    'message' => $email['message'],
                    'category' => $categoriesName,
                ]);
            }

        } catch (\Exception $e) {
            return 'IMAP connection error: ' . $e->getMessage();
        }
        
        //fetch emails from database
        $emailsFromDatabase = InboxEmails::all();     
        return view('inbox', ['emails' => $emailsFromDatabase]);
    }

    //fetch outbox emails and show in table
    public function showOutbox() {
        $outboxEmails = OutboxEmails::all();
        return view('outbox', ['outboxEmails' => $outboxEmails]);
    }

    //show the form the send emails to others
    public function showNewMailForm() {
        return view('sendNewMail');
    }

    //Logic to send the mail
    public function sendMail(Request $request) {
        //pass and validate data from inputs to $data variable
        $data = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:5',
            
        ]);

        $file = $request->validate([
            'attachment' => 'nullable|mimes:jpg,png,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        try { 
            
            //save attachment and send with email
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {

                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('attachments', $fileName, 'public');

                $job = (new SendEmailJob($data, $attachmentPath));
                dispatch($job);
                OutboxEmails::create($data);
                return redirect()->route('inbox')->with('success', 'Mail sent successfully!');

            } else {

                //send without attachment
                $job = (new SendEmailJob($data, $attachmentPath));
                dispatch($job);
                OutboxEmails::create($data);
                return redirect()->route('inbox')->with('success', 'Mail sent successfully!');

            }

        } catch(Exception $e) {

            echo "Error... " . $e;

        } 
    }

    //show outbox email details page data
    public function showMail($id) {
        $outboxEmails = OutboxEmails::find($id);
        $mail = [
            'id' => $id,
            'from' => 'yourGmail@gmail.com',
            'to' => $outboxEmails['email'],
            'subject' => $outboxEmails['subject'],
            'message' => $outboxEmails['message'],
            'date' => $outboxEmails['created_at']
        ];
        return view('showOutboxMail', ['mail' => $mail]);
    }

    //show inbox email details page data
    public function showInboxMail($id) {
        $inboxEmails = InboxEmails::find($id);
        $mail = [
            'id' => $inboxEmails['id'],
            'from' => $inboxEmails['from'],
            'to' => 'yourGmail@gmail.com',
            'subject' => $inboxEmails['subject'],
            'message' => $inboxEmails['message'],
            'category' => $inboxEmails['category'],
            'date' => $inboxEmails['created_at'],
        ];
        return view('showInboxMail', ['mail' => $mail]);
    }

    //go to reply to page with the same email that send you email and subject
    public function replyInboxMail($id) {
        $inboxEmails = InboxEmails::find($id);
        $replyMail = [
            'id' => $inboxEmails['id'],
            'from' => $inboxEmails['from'],
            'to' => 'yourGmail@gmail.com',
            'subject' => $inboxEmails['subject'],
            'message' => 'this is message',
            'date' => $inboxEmails['created_at'],
        ];
        return view('sendNewMail', ['replyMail' => $replyMail]);
    }

    //go to Forward to page with the same subject and message
    public function forwardInboxMail($id) {
        $inboxEmails = InboxEmails::find($id);
        $forwardMail = [
            'id' => $inboxEmails['id'],
            'from' => $inboxEmails['from'],
            'to' => 'yourGmail@gmail.com',
            'subject' => $inboxEmails['subject'],
            'message' => 'this is message',
            'date' => $inboxEmails['created_at'],
        ];
        return view('sendNewMail', ['forwardMail' => $forwardMail]);
    }

    //get category id from keyword id in messages
    private function getCategoryId($email) {
        $keywords = Keyword::all();    
        foreach ($keywords as $keyword) {
            if (stripos($email['message'], $keyword['keyword']) !== false) {
                $email['category_id'] = $keyword['category_id'];
                return $email['category_id'];
                break;
            }
        }
    }

    //get category name from category id
    private function getCategoryName($categoryId) {
        $categories = Category::all(); 
        foreach ($categories as $category) {
            if ($category['id'] == $categoryId) {
                return $category['name'];
            } else {
                return 'general';
            }
        }
    }
}
