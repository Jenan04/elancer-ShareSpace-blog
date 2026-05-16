<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" class="w-4 h-4" href="{{ asset('assets/s2.webp') }}">
    <title>{{ $title ?? 'ShareSpace - Connect your team&apos;s knowledge' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Geist', sans-serif; scroll-behavior: smooth; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface text-on-surface">
    <x-navbar />
    <x-hero />
    <x-features />
    <x-cta />
    <x-footer />

   
</body>
</html>