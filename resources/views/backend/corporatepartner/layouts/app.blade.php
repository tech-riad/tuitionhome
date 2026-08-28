<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('backend/file/images/fav.png') }}" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/color_palets.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/style.css') }}" />
    <title>Admin Corporate Partner</title>
</head>

<body>
    <!-- navbar starts here -->
    <nav class="navbar navbar-expand-lg bg-white shadow-lg fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a href="/index.html"><img src="/images/logo.svg" alt="logo" /></a>
            <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="navbarColor02" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-caret-down-fill"></i>
            </button>
        </div>
    </nav>
    <!-- navbar ends here -->

    <div class="container-fluid">
        <div class="row">
            <!-- sidebar starts here -->
            @include('backend.corporatepartner.layouts.sidebar')
            <!-- sidebar ends here -->
            <main class="container-custom">
                
                    <!-- mini nav starts here -->
                    <!-- mini nav ends here -->
                    <!-- main content section starts here -->
                    <!-- header cards starts here -->
                    @yield('content')
                    <!-- main content section ends here -->
                
            </main>
        </div>
    </div>
    @stack('third_party_scripts')

    @stack('page_scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
