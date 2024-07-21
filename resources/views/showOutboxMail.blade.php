@extends('layouts.app')

{{-- page to show outbox email from view button in the outbox page --}}

@section('header')
    Email
@endsection

@section('content')
    <h2>Mail Details</h2>
    <p><strong>From:</strong> {{ $mail['from'] }}</p>
    <p><strong>To:</strong> {{ $mail['to'] }}</p>
    <p><strong>Subject:</strong> {{ $mail['subject'] }}</p>
    <p><strong>Sending Date:</strong> {{ $mail['date'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $mail['message'] }}</p>
    <a href="{{ url()->previous() }}" class="btn">Back</a>
@endsection
