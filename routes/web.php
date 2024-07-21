<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

//inbox page
Route::get('/', [MailController::class, 'showInbox'])->name('inbox');

//outbox page
Route::get('/outbox', [MailController::class, 'showOutbox'])->name('outbox');

//show form that sending email
Route::get('/new', [MailController::class, 'showNewMailForm'])->name('sendNewMail');

//send email and redirect to inbox page
Route::post('/new', [MailController::class, 'sendMail'])->name('send.mail');

//show outbox email details page
Route::get('/mail/{id}', [MailController::class, 'showMail'])->name('show.mail');

//show inbox email details page
Route::get('/inboxMail/{id}', [MailController::class, 'showInboxMail'])->name('show.inbox.mail');

//go to reply to page with the same email that send you email and subject
Route::get('/newReply/{id}', [MailController::class, 'replyInboxMail'])->name('reply.show.mail');

//go to Forward to page with the same subject and message
Route::get('/newForward/{id}', [MailController::class, 'forwardInboxMail'])->name('forward.show.mail');
