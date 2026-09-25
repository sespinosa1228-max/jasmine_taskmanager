<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Taskflow' }} · Taskflow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap" rel="stylesheet">
    @if (is_file(public_path('build/manifest.json')))
        @php($manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true))
        <link rel="stylesheet" href="/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    @yield('content')
</body>
</html>