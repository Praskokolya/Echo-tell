@vite(['resources/js/app.js', 'resources/css/app.css'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base_url" content="{{ asset('/') }}">

    <title>Document</title>
</head>

<body>
    <div id="app">
        <!-- <header-component></header-component> -->
        <welcome-page></welcome-page>
    </div>

</body>

</html>