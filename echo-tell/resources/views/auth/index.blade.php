@vite(['resources/js/app.js', 'resources/css/app.css'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        @if(isset($authToken))
            window.token = "{{ $authToken }}";
            localStorage.setItem('access_token', window.token);
        @else
            console.log("No auth token found.");
        @endif
    </script>
    

</head>

<body>
    <div id="app"> 
        <auth-page></auth-page>
    </div>
</body>

</html>