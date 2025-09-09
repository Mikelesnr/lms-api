<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification Error</title>
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
        }
        .error-code {
            font-size: 1.2rem;
            color: #c00;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Email Verification Failed</h1>
        <p class="error-code">{{ $reason }}</p>
        <p>Please check your verification link or contact support.</p>
    </div>
</body>
</html>
