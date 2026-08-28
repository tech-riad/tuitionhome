<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" href="{{ asset('backend/file/images/fav.png') }}" />

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/file/css/bootstrap.min.css') }}" />

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/file/css/color_palets.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/style.css') }}" />

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0ZLxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e"
        crossorigin="anonymous" />

    {{-- Select2 CSS --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <title>Admin Corporate Partner</title>

    @stack('third_party_stylesheets')

    @stack('page_css')

</head>


<body>

    <!-- Navbar starts here -->
    <nav class="navbar navbar-expand-lg bg-white shadow-lg fixed-top"
        data-bs-theme="dark">

        <div class="container-fluid">

            <a href="/index.html">
                <img src="/images/logo.svg" alt="logo" />
            </a>

            <button class="navbar-toggler d-md-none collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu"
                aria-controls="navbarColor02"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <i class="bi bi-caret-down-fill"></i>

            </button>

        </div>

    </nav>
    <!-- Navbar ends here -->


    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar starts here -->

            @include('backend.corporatepartner.layouts.sidebar')

            <!-- Sidebar ends here -->


            <main class="container-custom">

                <!-- Main content starts here -->

                @yield('content')

                <!-- Main content ends here -->

            </main>

        </div>

    </div>


    {{-- ================================================= --}}
    {{-- JAVASCRIPT DEPENDENCIES --}}
    {{-- ================================================= --}}


    {{-- jQuery MUST come first --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous">
    </script>


    {{-- Select2 JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    {{-- Third party page scripts --}}
    @stack('third_party_scripts')


    {{-- Page specific scripts MUST be LAST --}}
    @stack('page_scripts')


</body>

</html>