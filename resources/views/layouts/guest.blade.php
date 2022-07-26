<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- font css -->
        <link rel="stylesheet" href="{{ url('/').'/'.asset('assets/fonts/feather.css') }}">
        <link rel="stylesheet" href="{{ url('/').'/'.asset('assets/fonts/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ url('/').'/'.asset('assets/fonts/material.css') }}">
        <!-- vendor css -->
        <link rel="stylesheet" href="{{ url('/').'/'.asset('assets/css/style.css') }}" id="main-style-link">
        <link rel="stylesheet" href="{{ url('/').'/'.asset('assets/css/customizer.css') }}">
    </head>
    <body>
        <!-- [ auth-signin ] start -->
        <div class="auth-wrapper bg_v">
            {{ $slot }}
        </div>
    </body>
</html>
