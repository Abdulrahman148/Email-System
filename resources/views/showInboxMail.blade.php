@extends('layouts.app')

{{-- page to show inbox email from view button in the inbox page --}}

@section('header')
    Email
@endsection

@section('content')
    <h2>Mail Details</h2>
    <p><strong>From:</strong> {{ $mail['from'] }}</p>
    <p><strong>To:</strong> {{ $mail['to'] }}</p>
    <p><strong>Subject:</strong> {{ $mail['subject'] }}</p>
    <p><strong>Sending Date:</strong> {{ $mail['date'] }}</p>
    <p><strong>Category:  </strong><strong class="category"> {{ $mail['category'] }} </strong></p>
    <p><strong>Message:</strong></p>
    <p>{{ $mail['message'] }}</p>

    <a href="{{ url()->previous() }}" class="btn">Back</a>
    <a href="{{ route('reply.show.mail', $mail['id']) }}" class="btn">Reply</a>
    <a href="{{ route('forward.show.mail', $mail['id']) }}" class="btn">Forward</a>
    
@endsection
