<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Learn Vue JS</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main id="parsinta">
        <navigation></navigation>

        <div class="py-4">
            <router-view></router-view>
        </div>
    </main>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/6eae20eef6.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>