<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta inertia head-key="description" name="description" content="Laravel">

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        {{-- Scripts --}}
        @routes
        @php
            $module = explode('::', $page['component']);
            $component = count($module) > 1
                ? "modules/{$module[0]}/resources/vue/{$module[1]}.vue"
                : "resources/vue/{$page['component']}.vue";
        @endphp
        @vite([ 'resources/js/app.ts', 'resources/css/app.css', $component ])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
