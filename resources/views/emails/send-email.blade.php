
{{-- this is page (Markdown) that Format email sending by this system --}}

<x-mail::message>
# Email System

<h3>email: {{ $data['email'] }}</h3>
<h3>subject: {{ $data['subject'] }}</h3>
<h3>Message: {{ $data['message'] }}</h3>
<h3>Sending Date : {{ $data['created_at'] }}</h3>

<x-mail::button :url="''">
    Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
