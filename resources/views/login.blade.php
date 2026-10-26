<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Inventory System') | {{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="wrapper">
            <form class="loginbox" method="POST" action="/login">
                @csrf
                <div class="login-header">
                    <div class="logo">📦</div>
                    <h1>Welcome back</h1>
                    <p>Sign in to manage your inventory</p>
                </div>  

                @if ($errors->any())
                    <div class="alert">{{ $errors->first() }}</div>
                @endif

                <div class="field">
                    <label for="user">Username</label>
                    <input type="text" id="user" name="user" placeholder="Enter your username" value="{{ old('user') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn">Sign in</button>
            </form>
        </div>
    </body>
</html>