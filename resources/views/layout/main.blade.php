@include('partials.header')
@include('partials.sidebar')


<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid mt-3">
        @yield('judul')
        <marquee behavior="scroll" direction="left" class="label label-dark" id="jam" onmouseover="this.stop();"
            onmouseout="this.start();">
            Selamat Datang di Website Kasir Percetakan | {{ env('APP_NAME') }} | Jika ada kendala silakan chat agent di
            <b>Live Chat</b> atau <a href="https://wa.me/{{ env('WHATSAPP') }}" target="_blank"
                class="text-warning">Hubungi
                Admin</a>, Terima Kasih <i class="fa fa-heart text-danger"></i>
        </marquee>

        @yield('content')
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
{{-- @yield('js') --}}
@include('partials.footer')
@yield('js')
