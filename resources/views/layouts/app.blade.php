<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'STUDEE')</title>
    @vite('resources/css/app.css')

    <link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#0f172a">

</head>


<body class="min-h-screen flex flex-col
bg-[#3B3B1A]">

    @include('layouts.components.navbar')

    <main class="flex-1 w-full pt-20">
        @yield('content')
    </main>

    @include('layouts.components.footer')

    @yield('scripts')
</body>

<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}
</script>

</html>
