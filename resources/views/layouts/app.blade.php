<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard')</title>

    <!-- Sneat CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/core.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/theme-default.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <!-- Boxicons -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/iconify-icons.css') }}">


    <!-- JS Helper -->
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            {{-- Sidebar --}}
            @include('partials.sidebar')

            <!-- Layout container -->
            <div class="layout-page">
                {{-- Navbar --}}
                @include('partials.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    {{-- Footer --}}
                    @include('partials.footer')
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
    @yield('scripts')
</body>

</html>
