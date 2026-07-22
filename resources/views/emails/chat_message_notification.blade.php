<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Chat Message</title>
</head>
<body>
    <h1>New Chat Message Received</h1>
    <p>A customer has sent a new message to the chat.</p>

    <p><strong>From:</strong> {{ $conversation->customer_name ?? 'Guest' }}</p>
    <p><strong>Email:</strong> {{ $conversation->customer_email ?? 'Not provided' }}</p>
    <p><strong>Message:</strong></p>
    <div style="border:1px solid #ddd; padding:12px; background:#f8f8f8; white-space:pre-wrap;">{{ $chatMessage->message }}</div>

    @if($pageTitle || $pageUrl)
        <p><strong>Page:</strong> {{ $pageTitle ?? 'N/A' }}</p>
        <p><strong>URL:</strong> <a href="{{ $pageUrl }}">{{ $pageUrl }}</a></p>
    @endif

    <p>Conversation ID: {{ $conversation->id }}</p>
    <p>Session ID: {{ $conversation->session_id }}</p>
</body>
</html>
