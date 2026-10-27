<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="wrapper">
        <div class="loginbox">
            <div class="login-header">
                <div class="logo">📦</div>
                <h1>Inventory</h1>
                <p>Welcome, {{ auth()->user()->username }}!</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn" style="width:100%">Log out</button>
            </form>
        </div>
    </div>
</body>
</html>