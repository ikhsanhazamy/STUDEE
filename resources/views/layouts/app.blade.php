<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'STUDEE')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#0f172a">

</head>


<body class="min-h-screen flex flex-col bg-[#444422] font-sans">

    @include('layouts.components.navbar')

    <main class="flex-1 w-full pt-[108px]">
        @yield('content')
    </main>

    @include('layouts.components.footer')

    @auth
        @include('layouts.components.ai-chat')
    @endauth

    @yield('scripts')
</body>

<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}
</script>

</html>
