<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification Diagnostic</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f9f9f9;
            padding: 2rem;
            text-align: center;
        }
        .info-box {
            background: #fff;
            border: 1px solid #ccc;
            padding: 2rem;
            display: inline-block;
            margin-top: 5rem;
            max-width: 600px;
        }
        .info-box p {
            margin: 0.5rem 0;
            font-size: 0.95rem;
            color: #333;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="info-box">
        <h1>Email Verification Diagnostic</h1>
        <p><strong>Status:</strong> {{ $reason }}</p>
        <p><strong>User ID:</strong> {{ $user_id }}</p>
        <p><strong>Provided Hash:</strong> {{ $provided_hash }}</p>
        <p><strong>Request URL:</strong> {{ $url }}</p>
    </div>
</body>
</html>
