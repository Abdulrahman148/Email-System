@extends('layouts.app')

{{-- page to show all outbox messages --}}

@section('header')
    Mail Outbox
@endsection

@section('content')
    <table>
        <thead>
            <tr>
                <th>To</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outboxEmails as $email)
            <tr>
                <td>{{ $email['email'] }}</td>
                <td>{{ $email['subject'] }}</td>
                <td>{{ $email['created_at'] }}</td>
                <td style="text-align: center">
                    <a href="{{ route('show.mail', $email['id']) }}" class="btn">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
