@extends('layouts.app')

{{-- page to show all inbox messages --}}

@section('header')
    Mail Inbox
@endsection

@section('content')

    @if(session('success'))
        <div class="messageSentSuccessfully">  {{ session('success') }} </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Category</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $email)
            <tr>
                <td>{{ $email['from'] }}</td>
                <td>{{ $email['subject'] }}</td>
                <td>{{ $email['category'] }}</td>
                <td>{{ $email['created_at'] }}</td>
                <td style="text-align: center">
                    <a href="{{ route('show.inbox.mail', $email['id']) }}" class="btn">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection

