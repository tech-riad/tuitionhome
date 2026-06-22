<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />

{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/changed-bootstrap-v1.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/job.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/payment.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/profile.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/member.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/adminlte.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/setting.css" />
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/tarminal.css" />



    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <title>Dashboard</title>
    @stack('css')
</head>
<body>
<div>
    <!-- navbar section -->
    <div x-data="{ open: false }">
        <!-- navbar section -->
        <nav
            class="navbar navbar-expand-lg navbar-light bg-white t-navbar fixed-top"
        >
            <div class="container-fluid d-flex justify-content-between">

                <a class="navbar-brand" href="#">
                    <img src="{{asset('/dashboard/tutor')}}/assets/logo.svg" alt="logo" />
                </a>
                @if(is_active() != true)
                    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" >
                        <strong>First active your account then you can edit your profile information.</strong>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div
                    style="color: #7cb305"
                    class="d-md-none mx-2"
                    @click="open = !open"
                >
                    <i class="bi bi-menu-button-wide"></i>

                </div>

                <div class="mx-3 d-none d-md-block">
                    <div
                        class="d-flex justify-content-between align-content-center mt-3"
                    >
                        <div class="mx-2">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::guard('tutor')->user()->name }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('tutor.profile-view') }}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('tutor.Setting') }}">Setting</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('TutorLogoutForm').submit();">Logout</a></li>
                                    <form id="TutorLogoutForm" action="{{ route('tutor.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </nav>
    <!-- navbar section end -->
    <!-- sidebar section starts -->
    @include('dashboard.tutor.sidebar')
    <!-- sidebar section ends -->
    <!-- conent section starts -->
   @yield('content')
    <!-- conent section ends -->
</div>
</div>
{{--    jquery cdn--}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" ></script>
{{--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

{{--    bootstrap cdn--}}

{{--    alpain js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@stack('js')
</body>
</html>
