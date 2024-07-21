{{-- the basic layout that contain header and sidebar --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('resources/allCss.css') }}">
    <title>Email System</title>
    <style></style>
</head>
<body>
    <header>
        <h1>
            @yield('header', 'Mail Inbox')
        </h1>
    </header>
    <div class="container">
        <div class="sidebar">
            <a href="{{ route('inbox') }}">Inbox</a>
            <a href="{{ route('outbox') }}">Outbox</a>
            <a href="{{ route('sendNewMail') }}">Send New Mail</a>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>

