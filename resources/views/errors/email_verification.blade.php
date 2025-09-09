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
        .error-box {
            background: #fff;
            border: 1px solid #ccc;
            padding: 2rem;
            display: inline-block;
            margin-top: 5rem;
            max-width: 600px;
        }
        .error-code {
            font-size: 1.2rem;
            color: #c00;
            margin-bottom: 1rem;
        }
        .info {
            text-align: left;
            margin-top: 1rem;
            font-size: 0.95rem;
            color: #333;
        }
        .info p {
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Email Verification Diagnostic</h1>
        <p class="error-code">{{ $reason }}</p>
        <p>Please check your verification link or contact support.</p>

        <div class="info">
            @isset($user_id)
                <p><strong>User ID:</strong> {{ $user_id }}</p>
            @endisset

            @isset($expected_hash)
                <p><strong>Expected Hash:</strong> {{ $expected_hash }}</p>
            @endisset

            @isset($provided_hash)
                <p><strong>Provided Hash:</strong> {{ $provided_hash }}</p>
            @endisset

            @isset($url)
                <p><strong>Request URL:</strong> {{ $url }}</p>
            @endisset
        </div>
    </div>
</body>
</html>
