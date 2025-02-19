<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statistics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        .statistics {
            list-style-type: none;
            padding: 0;
        }
        .statistic-item {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .statistic-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .statistic-item p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Your statistics for {{ now()->format('d m Y') }}</h1>
    <ul class="statistics">
        @foreach ($statistics as $key => $statistic)
            <li class="statistic-item">
                <h3>{{ ucwords(str_replace('_', ' ', $key)) }}</h3>
                <p>{{ $statistic }}</p>
            </li>
        @endforeach
    </ul>
    <h1>Thank you for choosing Echo Tell!</h1>
</body>
</html>
