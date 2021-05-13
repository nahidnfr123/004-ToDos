<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="text-gray-900 leading-tight dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ Config::get('app.name', 'Todo App') }}</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css"/>
    <link rel="icon" href="{{ asset('images/to-do-list.png') }}" type="image/icon type">

    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
</head>
<body class="min-h-screen antialiased bg-gray-100 dark:bg-gray-900 font-sans relative">


<div id="app"></div>


<script src="{{ asset('dist/js/app.js') }}" defer></script>
<script>
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.querySelector('html').classList.add('dark')
    } else {
        document.querySelector('html').classList.remove('dark')
    }

    // Whenever the user explicitly chooses light mode
    localStorage.theme = 'light'

    // Whenever the user explicitly chooses dark mode
    localStorage.theme = 'dark'

    // Whenever the user explicitly chooses to respect the OS preference
    localStorage.removeItem('theme')
</script>

</body>
</html>
