<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <style>
        body { background:#f4f7fb; color:#243447; font-family:Arial, sans-serif; margin:0; }
        .career-share-header { background:#008749; color:#fff; padding:17px 24px; }
        .career-share-header-inner { font-size:17px; font-weight:700; margin:0 auto; max-width:1100px; }
        .career-share-footer { color:#8a97a6; font-size:12px; padding:24px; text-align:center; }
    </style>
    @stack('page_css')
</head>
<body>
    <header class="career-share-header">
        <div class="career-share-header-inner">{{ config('app.name') }} | Shared Job</div>
    </header>
    @yield('content')
    <footer class="career-share-footer">Job details shared from {{ config('app.name') }}.</footer>
    @stack('page_scripts')
</body>
</html>
