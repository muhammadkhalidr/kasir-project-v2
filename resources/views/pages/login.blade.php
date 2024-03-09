<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - {{ env('APP_NAME') }}</title>
    <meta name="description" content="Aplikasi Kasir Percetakan untuk Meningkatkan Efisiensi Bisnis Anda">
    <meta name="keywords"
        content="aplikasi kasir percetakan, percetakan, aplikasi kasir, manajemen bisnis, cetak, faktur, pos kasir, pos percetakan, khalid r">
    <meta name="author" content="khalid r">
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <!-- Open Graph untuk berbagi di media sosial -->
    <meta property="og:title" content="Aplikasi Kasir Percetakan | Khalid R">
    <meta property="og:description" content="Aplikasi Kasir Percetakan untuk Meningkatkan Efisiensi Bisnis Anda">
    <meta property="og:url" content="https://www.khalidr.site">
    <meta property="og:type" content="website">
    <meta property="og:image" content="assets/images/settings/login-logo.png">
    <meta property="og:site_name" content="Khalid R - Kasir Percetakan" />

    <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "SoftwareApplication",
          "name": "Aplikasi Kasir Percetakan",
          "operatingSystem": "Cross-platform",
          "applicationCategory": "BusinessApplication",
          "description": "Aplikasi kasir yang dirancang khusus untuk percetakan, membantu meningkatkan efisiensi dan produktivitas bisnis.",
          "softwareVersion": "1.3",
          "author": {
            "@type": "Organization",
            "name": "khalid r"
          },
          "image": "assets/images/settings/login-logo.png",
          "url": "https://khalidr.site",
          "screenshot": "assets/images/settings/home.png"
        }
        </script>

    <!-- Favicon icon -->
    @foreach ($logo as $item)
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/settings/{{ $item->favicon }}">
    @endforeach
    <link href="{{ asset('/') }}assets/css/style.css" rel="stylesheet">

</head>

<body class="h-100">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            @foreach ($logo as $item)
                <img src="assets/images/settings/{{ $item->favicon }}" alt="" class="logo-loader">
            @endforeach
            <h6 class="text-center">Loading...</h6>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                @foreach ($logo as $item)
                                    <img src="assets/images/settings/{{ $item->login_logo }}"
                                        alt="{{ $item->perusahaan }}" class="logo-login">
                                @endforeach
                                <a class="text-center" href="{{ asset('/') }}">
                                    <h4>Login</h4>
                                </a>
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button> {{ session('error') }}
                                    </div>
                                @endif
                                <form class="mb-5 login-input" action="{{ url('login/proses') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input autofocus type="text"
                                            class="form-control @error('username')
                                            is-invalid
                                        @enderror"
                                            placeholder="Username" name="username" value="{{ old('username') }}">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control @error('password')
                                            is-invalid
                                        @enderror"
                                            placeholder="Password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button class="btn login-form__btn submit w-100">Login</button>
                                </form>
                                <h4 class="text-center">Akun Demo</h4>
                                <hr>
                                <h6 class="text-center">Owner</h6>
                                <ul class="list-unstyled text-center">
                                    <li>Username : owner</li>
                                    <li>Password : 12345</li>
                                </ul>
                                <hr>
                                <h6 class="text-center">Kasir</h6>
                                <ul class="list-unstyled text-center">
                                    <li>Username : kasir</li>
                                    <li>Password : 12345</li>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('/') }}assets/plugins/common/common.min.js"></script>
    <script src="{{ asset('/') }}assets/js/custom.min.js"></script>
    <script src="{{ asset('/') }}assets/js/settings.js"></script>
    <script src="{{ asset('/') }}assets/js/gleek.js"></script>
    <script src="{{ asset('/') }}assets/js/styleSwitcher.js"></script>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
</body>

</html>
