<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Aplikasi POS Percetakan">
    <meta name="keywords" content="point of sale, pos percetakan, aplikasi percetakan, khalid r, percetakan">
    <meta name="author" content="Khalid R">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ $logo->first()->perusahaan }}</title>

    <!-- Favicon icon -->
    @foreach ($logo as $item)
        <link rel="icon" type="image/png" sizes="16x16"
            href="{{ asset('/') }}assets/images/settings/{{ $item->favicon }}">
    @endforeach
    <!-- Custom Stylesheet -->
    {{-- select2 --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/') }}/assets/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <link href="{{ asset('/') }}assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('/') }}assets/plugins/toastr/css/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            @foreach ($logo as $item)
                <img src="{{ asset('/') }}assets/images/settings/{{ $item->favicon }}" alt=""
                    class="logo-loader">
            @endforeach
            <h6 class="text-center">Loading...</h6>
        </div>
    </div>
    <!--*******************
            Preloader end
        ********************-->


    <!--**********************************
            Main wrapper start
        ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
                Nav header start
            ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="{{ asset('/') }}">
                    @foreach ($logo as $item)
                        <b class="logo-abbr"><img src="{{ asset('/') }}assets/images/settings/{{ $item->logo }}"
                                alt=""> </b>
                        <span class="logo-compact"><img
                                src="{{ asset('/') }}assets/images/settings/{{ $item->logo }}"
                                alt=""></span>
                        <span class="brand-title">
                            <img src="{{ asset('/') }}assets/images/settings/{{ $item->logo }}" alt=""
                                width="120">
                        </span>
                    @endforeach
                </a>
            </div>
        </div>
        <!--**********************************
                Nav header end
            ***********************************-->

        <!--**********************************
                Header start
            ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                @foreach ($foto as $item)
                                    <img src="{{ asset('/') }}assets/images/avatar/{{ $item->foto }}"
                                        height="40" width="40" alt="">
                                @endforeach
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            @if (auth()->check() && auth()->user()->level == 1)
                                                <span class="badge-dot badge-primary">{{ $name_user }}</span>
                                            @else
                                                <span>{{ $name_user }}</span>
                                            @endif
                                        </li>


                                        <li>
                                            <a href="{{ url('profile') }}"><i class="icon-user"></i>
                                                <span>Profile</span></a>
                                            <hr class="my-2">
                                            @if (auth()->check() && (auth()->user()->level == 1 || auth()->user()->level == 2 || auth()->user()->level == 5))
                                                <a href="{{ url('setting') }}"><i class="fa fa-cogs"></i>
                                                    <span>Setting</span></a>
                                            @endif
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="{{ url('logout') }}"><i class="icon-key"></i>
                                                <span>Logout</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
                Header end ti-comment-alt
            ***********************************-->

        @if ($logo->first()->demo == 'Y')
            <div class="cards" style="background-color: #7571f9; overflow: hidden;">
                <div class="text-white demo-text" id="demoMode">
                    <i class="fa fa-bell"></i> Saat ini anda dalam mode demo
                </div>
            </div>
        @endif

        @push('scripts')
            <script>
                // Animation to replace marquee
                let position = 0;
                const text = document.getElementById("demoMode");
                const cardWidth = document.querySelector(".cards").offsetWidth;

                function animateDemoText() {
                    position -= 1;
                    if (position < -text.offsetWidth) {
                        position = cardWidth;
                    }
                    text.style.left = position + "px";
                    requestAnimationFrame(animateDemoText);
                }

                animateDemoText();
            </script>
        @endpush

        <style>
            .cards {
                position: relative;
                width: 100%;
                height: 40px;
                /* Sesuaikan dengan tinggi teks Anda */
                line-height: 40px;
                /* Sesuaikan dengan tinggi teks Anda */
                white-space: nowrap;
                overflow: hidden;
            }

            .demo-text {
                position: absolute;
                left: 100%;
                /* Memulai teks di luar layar */
                animation: moveText 50s linear infinite;
                padding-left: 10px;
                /* Jarak ikon */
            }

            @keyframes moveText {
                from {
                    left: 100%;
                }

                to {
                    left: -100%;
                    /* Sesuaikan dengan kebutuhan Anda */
                }
            }
        </style>
