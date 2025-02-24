<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Email Confirmation' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }
        .code {
            font-size: 22px;
            background-color: #f0f0f0;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Email Confirmation</h1>
        <p>Use this code to confirm your email:</p>
        <p class="code">{{ $code }}</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Echo Tell</p>
        </div>
    </div>
</body>
</html>
