<!DOCTYPE html>
<html>

<head>

    <style>


    </style>

    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{asset('/pen.png')}}">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />


    <link href="{{ asset('backend/parent/css/parent-admin.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/parent/css/af-view.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/parent/css/af-edit.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/parent/lead/style.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('backend/parent/css/style.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('backend/parent/css/color_palets.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('backend/parent/css/log_file_style.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('backend/parent/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}




    {{-- selec2 cdn link --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.css"
        integrity="sha512-EzrsULyNzUc4xnMaqTrB4EpGvudqpetxG/WNjCpG6ZyyAGxeB6OBF9o246+mwx3l/9Cn838iLIcrxpPHTiygAA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
        integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
        integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />


    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        integrity="sha512-aEe/ZxePawj0+G2R+AaIxgrQuKT68I28qh+wgLrcAJOz3rxCP+TwrK5SPN+E5I+1IQjNtcfvb96HDagwrKRdBw=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- summernote css link--}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    {{-- end summernote css link --}}


    {{-- dashboard joboffer module css link --}}

    <link href="{{ asset('css/backend/add_offer.css') }}" rel="stylesheet" />

    <link href="{{ asset('template/tution-terminal-admin-offer/css/color_palets.css') }}" rel="stylesheet" />
    {{-- button colour change & error for this link --}}
    {{-- <link href="{{ asset('template/tution-terminal-admin-offer/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    {{-- end error link --}}
    <link href="{{ asset('template/tution-terminal-admin-offer/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/tution-terminal-admin-offer/css/custom-switch-and-checkbox.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('template/tution-terminal-admin-offer/css/owl/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/tution-terminal-admin-offer/css/owl/owl.theme.default.min.css') }}"
        rel="stylesheet" />


    {{-- taken offer link start --}}

    {{-- <link href="{{ asset('template/taken_offer/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('template/taken_offer/css/color_palets.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('template/taken_offer/css/style.css') }}" rel="stylesheet" /> --}}
    {{-- <link href="{{ asset('template/taken_offer/css/tab.css') }}" rel="stylesheet" /> --}}

    {{--end taken offer link start --}}




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous" />
    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MCX2SQR');

    </script>
    <!-- End Google Tag Manager -->
    {{--End dashboard joboffer module css link --}}

    @stack('third_party_stylesheets')

    @stack('page_css')
    <style>
        #about_category_first {
            display: none;
        }

    </style>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-light" style="background-color: #008749">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                            class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline text-white">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                                class="img-circle elevation-2" alt="User Image">
                            <p>
                                {{ Auth::user()->name }}
                                <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        @if(in_array(Auth::user()->role_id, [1, 6]))
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <a href="#" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        @else
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signoutModal">
                                Sign out
                            </button>
                        </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>


        <div class="modal fade" id="signoutModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <p>Enter A Valid Reason For Signout</p>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form id="" method="post" action="{{ route('employee.logout') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="logout Reason" class="form-label">Signout Reason</label>
                                <textarea name="logout_reason" class="form-control" id="logoutreason" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="Duration In time" class="form-label">Approximate Duration</label>
                                <input type="text" name="logout_duration_apx" class="form-control" id="duration" placeholder="e.g:15 minutes" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Confirm Signout</button>
                    </div>
                    </form>

                </div>

            </div>
        </div>


        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                @yield('content')
            </section>
        </div>

        <!-- Main Footer -->
        <!-- <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            Powered By Tuition Terminal
        </div>
        <strong>
            Copyright © 2023 All Right Reserved.
        </strong>
    </footer> -->
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"
        integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"
        integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg=="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.3/bootstrapSwitch.min.js"
        integrity="sha512-DAc/LqVY2liDbikmJwUS1MSE3pIH0DFprKHZKPcJC7e3TtAOzT55gEMTleegwyuIWgCfOPOM8eLbbvFaG9F/cA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/js/datatables-simple-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    {{-- summernote js cdn link --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    {{--end summernote js cdn link --}}

    {{-- Dashboard joboffer module js link --}}




    {{-- <script src="{{ asset('template/tution-terminal-admin-offer/js/scripts.js') }}"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>




    {{--End Dashboard joboffer module js link --}}



    {{-- taken_offer module js link --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- <script src="{{ asset('template/taken_offer/js/sidebar.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{-- <script src="{{ asset('template/taken_offer/js/window.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- end taken_offer module js link --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"
        data-turbolinks-track="true"></script>
    <script src="{{ asset('template/tution-terminal-admin-offer/js/owl/owl.carousel.min.js') }}"></script>



    {{-- select2 cdn link --}}
    {{--
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

  <script>
    var allEditors = document.querySelectorAll('.editor');
    for (var i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i])
            .then(editor => {
                editor.ui.view.editable.element.style.height = '50vh';
            })
            .catch(error => {
                console.error(error);
            });
    }

</script> --}}

    <script>
        $(document).ready(function () {
            $(".owl-carousel").owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 1500,
                autoplayHoverPause: true,
                autoplaySpeed: 1000,
                margin: 10,
                responsiveClass: true,
                nav: true,
                navText: [
                    "<i class='bi bi-chevron-right arrow-icon'></i>",
                    "<i class='bi bi-chevron-left arrow-icon'></i>",
                ],
                navClass: ["carousel-nav-btn-prev", "carousel-nav-btn-next"],
                responsive: {
                    0: {
                        items: 1,
                        nav: true,
                        loop: true,
                    },
                    600: {
                        items: 2,
                        loop: true,
                    },
                    1000: {
                        items: 4,
                        nav: true,
                        loop: true,
                    },
                },
            });
        });

        function showNotification(type, message) {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
            };

            toastr[type](message);
        }

        $(function () {
            bsCustomFileInput.init();
        });

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    </script>

    <script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
    <script src="{{ asset('lineheight/plugin.js') }}"></script>

    <script>
        $(document).ready(function () {
            CKEDITOR.replace('learn_category', {
                skin: 'moono',
                enterMode: CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                toolbar: [{
                        name: 'basicstyles',
                        groups: ['basicstyles'],
                        items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor']
                    },
                    {
                        name: 'styles',
                        items: ['Format', 'Font', 'FontSize', 'LineHeight']
                    },
                    {
                        name: 'scripts',
                        items: ['Subscript', 'Superscript']
                    },
                    {
                        name: 'justify',
                        groups: ['blocks', 'align'],
                        items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent'],
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image']
                    },
                    {
                        name: 'spell',
                        items: ['jQuerySpellChecker']
                    },
                    {
                        name: 'table',
                        items: ['Table']
                    }
                ],
                extraPlugins: 'lineheight', // Include the Line Height plugin
                line_height: '1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23;24;25;26;27;28;29;30;31;32;33;34;35;36;37;38;39;40;41;42;43;44;45;46;47;48;49;50;51;52;53;54;55;56;57;58;59;60;61;62;63;64;65;66;67;68;69;70;71;72',
                lineHeight_style: {
                    element: 'span',
                    styles: {
                        'line-height': '#(size)'
                    },
                    overrides: [{
                        element: 'line-height',
                        attributes: {
                            'size': null
                        }
                    }]
                }
            });

            CKEDITOR.replace('about_category_first', {
                skin: 'moono',
                enterMode: CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                toolbar: [{
                        name: 'basicstyles',
                        groups: ['basicstyles'],
                        items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor']
                    },
                    {
                        name: 'styles',
                        items: ['Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'scripts',
                        items: ['Subscript', 'Superscript']
                    },
                    {
                        name: 'justify',
                        groups: ['blocks', 'align'],
                        items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent'],
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image']
                    },
                    {
                        name: 'spell',
                        items: ['jQuerySpellChecker']
                    },
                    {
                        name: 'table',
                        items: ['Table']
                    }
                ],
            });

            CKEDITOR.replace('about_category_second', {
                skin: 'moono',
                enterMode: CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                toolbar: [{
                        name: 'basicstyles',
                        groups: ['basicstyles'],
                        items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor']
                    },
                    {
                        name: 'styles',
                        items: ['Format', 'Font', 'FontSize', 'LineHeight']
                    },
                    {
                        name: 'scripts',
                        items: ['Subscript', 'Superscript']
                    },
                    {
                        name: 'justify',
                        groups: ['blocks', 'align'],
                        items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent'],
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink']
                    },
                    {
                        name: 'insert',
                        items: ['Image']
                    },
                    {
                        name: 'spell',
                        items: ['jQuerySpellChecker']
                    },
                    {
                        name: 'table',
                        items: ['Table']
                    }
                ],
                extraPlugins: 'lineheight', // Include the Line Height plugin
                lineheight: {
                    title: 'Line Height',
                    options: {
                        'default': '',
                        '1': '1',
                        '1.5': '1.5',
                        '2': '2',
                        '2.5': '2.5',
                        '3': '3'
                    }
                }
            });

            $('#courseForm').submit(function () {
                $('#learn_category').val(CKEDITOR.instances.learn_category.getData());
                $('#about_category_first').val(CKEDITOR.instances.about_category_first.getData());
                $('#about_category_second').val(CKEDITOR.instances.about_category_second.getData());
            });

            CKEDITOR.plugins.setLang('lineheight', 'en', {
                title: 'Line Height'
            });
        });

    </script>

{{-- Parent Caroseljs --}}

    <script>
        $(".live-on-owl-carousel").owlCarousel({
            items: 2,
            loop: true,
            margin: 25,
            nav: true,
            navContainer: "#postAJob_LiveOn_navContainer",
            navText: [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>',
            ],
            navClass: [
                "bg-gray-500 py-1 rounded-circle border-0 text-white my-3 mx-2",
                "bg-gray-500 py-1 rounded-circle border-0 text-white my-3 mx-2",
            ],
            dots: false,
            responsiveClass: true,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                1000: {
                    items: 2,
                    nav: true,
                },
            },
        });

    </script>
    <script>
        $(".live-off-owl-carousel").owlCarousel({
            items: 2,
            loop: true,
            margin: 25,
            nav: true,
            navContainer: "#postAJob_LiveOff_navContainer",
            navText: [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>',
            ],
            navClass: [
                "bg-gray-500 py-1 rounded-circle border-0 text-white my-3 mx-2",
                "bg-gray-500 py-1 rounded-circle border-0 text-white my-3 mx-2",
            ],
            dots: false,
            responsiveClass: true,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                1000: {
                    items: 2,
                    nav: true,
                },
            },
        });

    </script>

    <script>
        let lastActivityUpdate = Date.now();

        function updateSession() {
        let now = Date.now();

        if (now - lastActivityUpdate > 300000) { // 5 minutes
                fetch("{{ route('session.keep-alive') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ update: true })
                }).then(response => response.json())
                .then(data => console.log("Session Updated:", data))
                .catch(error => console.error("Keep-alive error:", error));

                lastActivityUpdate = now;
            }
        }

        // Listen to various activity events
        document.addEventListener("mousemove", updateSession);
        document.addEventListener("keydown", updateSession);
        document.addEventListener("click", updateSession);
        document.addEventListener("scroll", updateSession);

    </script>


    @stack('third_party_scripts')

    @stack('page_scripts')

    {{-- {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"
        data-turbolinks-track="true"></script>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MCX2SQR" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>

</html>
