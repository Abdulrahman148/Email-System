@extends('layouts.app')

{{-- page contain the form that send emails --}}

@section('header')
    Send New Email
@endsection

@section('content')
<form action="{{ route('sendNewMail') }}" method="POST" nctype="multipart/form-data">
    @csrf
    <label for="to">@if (Request::is('newForward/*')) Forward To: @elseif(Request::is('newReply/*')) Reply To: @else To: @endif</label>
    <input type="email" id="to" 
                        value="@if (Request::is('newReply/*')){{ $replyMail['from'] }} @endif" 
                        name="email" required>

    <label for="subject">Subject:</label>
    <input type="text"  id="subject" 
                        value="@if(Request::is('newReply/*')){{ $replyMail['subject'] }} @elseif(Request::is('newForward/*')) {{ $forwardMail['subject'] }} @endif" 
                        name="subject" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="10" required>@if (Request::is('newForward/*')){{ $forwardMail['message'] }} @endif</textarea>

    <label for="attachment">Attachment:</label>
    <input type="file" name="attachment" id="attachment">

    <button type="submit">Send Mail</button>
</form>
@endsection
