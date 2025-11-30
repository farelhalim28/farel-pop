<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dashboard Admin - FAREL POP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets-admin/assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets-admin/assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets-admin/assets/img/favicon/favicon-16x16.png') }}">

    {{-- START CSS --}}
    @include('layouts.admin.css')
    {{-- END CSS --}}

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
</head>

<body>
    {{-- START SIDEBAR --}}
    @include('layouts.admin.sidebar')
    {{-- END SIDEBAR --}}

    <main class="content">
        {{-- START HEADER --}}
        @include('layouts.admin.header')
        {{-- END HEADER --}}

        {{-- START MAIN CONTENT --}}
        @yield('content')
        {{-- END MAIN CONTENT --}}

        {{-- START FOOTER --}}
        @include('layouts.admin.footer')
        {{-- END FOOTER --}}
    </main>

    {{-- START JS --}}
    @include('layouts.admin.js')
    {{-- END JS --}}
</body>

</html>
