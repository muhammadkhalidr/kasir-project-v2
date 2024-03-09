@extends('settings.main')

@section('judul')
    <h3> <i class="fa fa-cogs"></i> Settings</h3>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @foreach ($data as $item)
                            <form action="{{ route('setting.update', $item->id_setting) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="{{ $item->id_setting }}" name="id_setting">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="perusahaan">Nama Perusahaan</label>
                                        <input type="text" class="form-control" id="perusahaan" name="nama_perusahaan"
                                            value="{{ $item->perusahaan }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ $item->email }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="{{ $item->alamat }}">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="phone">No Handphone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $item->phone }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="instagram">Instagram</label>
                                        <input type="text" class="form-control" id="instagram" name="ig"
                                            value="{{ $item->instagram }}">
                                    </div>
                                </div>
                                @if (auth()->check())
                                    @if (auth()->user()->level == 1)
                                        <hr>
                                        <h4 class="text-center"><i class="bi bi-clock"></i> Jam Transaksi</h4>
                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="dari">Dari Jam</label>
                                                <input type="number" class="form-control" id="dari" name="darijam"
                                                    value="{{ $item->darijam }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="sampaijam">Sampai Jam</label>
                                                <input type="number" class="form-control" id="sampaijam" name="sampaijam"
                                                    value="{{ $item->sampaijam }}">
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group">
                                    <label for="footer-invoice">Footer Invoice</label>
                                    <textarea name="footer_invoice" id="" cols="30" rows="10" class="form-control text-center">{{ $item->pesan }}
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="warnatema">Warna Tema</label>
                                    <span class="text-italic text-danger">Saat ini belum bisa di gunakan.</span>
                                    <input type="color" name="warnatema" class="form-control"
                                        value="{{ $item->warnatema }}">
                                </div>
                                @if (auth()->user()->level == 1)
                                    <div class="form-group mt-4">
                                        <label for="" class="form-label">Mode</label>
                                        <select name="mode" class="form-control">
                                            @php
                                                $demos = ['Y' => 'DEMO', 'N' => 'LIVE'];
                                            @endphp
                                            @foreach ($demos as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $item->demo == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('setting') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="inputGroupFileAddon03">
                                            <img class="imglogo" data-id="2" id="imglogo2"
                                                src="assets/images/settings/{{ $item->logo }}" height="20"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo" name="logo">
                                        <label class="custom-file-label" for="logo">Pilih Logo Perusahaan</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 72x72 px</small>
                            </div>
                            <div class="form-group">
                                <label for="favicon">Favicon</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="inputGroupFileAddon03">
                                            <img class="imglogo" data-id="2" id="imglogo2"
                                                src="assets/images/settings/{{ $item->favicon }}" height="20"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="favicon" name="favicon">
                                        <label class="custom-file-label" for="favicon">Pilih Favicon</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 72x72 px</small>
                            </div>
                            <div class="form-group">
                                <label for="logo_login">Logo Login</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="inputGroupFileAddon03">
                                            <img class="imglogo" data-id="2" id="imglogo2"
                                                src="assets/images/settings/{{ $item->login_logo }}" height="20"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo_login"
                                            name="logo_login">
                                        <label class="custom-file-label" for="logo_login">Pilih Logo lOGIN</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 1200x700 px</small>
                            </div>
                            <div class="form-group">
                                <label for="lunas">Logo Lunas</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="inputGroupFileAddon03">
                                            <img class="imglogo" data-id="2" id="imglogo2"
                                                src="assets/images/settings/{{ $item->logo_lunas }}" height="20"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="lunas" name="lunas">
                                        <label class="custom-file-label" for="lunas">Pilih Logo Belum Lunas</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 500x300 px</small>
                            </div>
                            <div class="form-group">
                                <label for="blunas">Logo Belum Lunas</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="inputGroupFileAddon03">
                                            <img class="imglogo" data-id="2" id="imglogo2"
                                                src="assets/images/settings/{{ $item->logo_blunas }}" height="20"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="blunas" name="blunas">
                                        <label class="custom-file-label" for="blunas">Pilih Logo Belum Lunas</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 500x300 px</small>
                            </div>
                            <div class="form-group">
                                <label for="qrcode">QR Code</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="inputGroupFileAddon03">
                                            <img class="imglogo" data-id="2" id="imglogo2"
                                                src="assets/images/qrcode/{{ $item->qrcode }}" height="20"
                                                alt="" />
                                        </button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="qrcode" name="qrcode">
                                        <label class="custom-file-label" for="qrcode">Pilih QR Code</label>
                                    </div>
                                </div>
                                <small id="logoHelp" class="form-text text-muted">size 700x700 px</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        @foreach ($data as $item)
                            <div class="form-group col-md-6">
                                <label for="">Logo</label>
                                <img src="assets/images/settings/{{ $item->logo }}" alt="Logo"
                                    class="logo-settings form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="faviocn">Favicon</label>
                                <img src="assets/images/settings/{{ $item->favicon }}" alt="favicon"
                                    class="favicon-settings form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="login-logo">Login Logo</label>
                                <img src="assets/images/settings/{{ $item->login_logo }}" alt="login-logo"
                                    class="logo-settings form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="login-logo">Login Lunas</label>
                                <img src="assets/images/settings/{{ $item->logo_lunas }}" alt="logo-lunas"
                                    class="logo-settings form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="login-logo">Login Belum Lunas</label>
                                <img src="assets/images/settings/{{ $item->logo_blunas }}" alt="logo-blunas"
                                    class="logo-settings form-control">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
<!-- #/ container -->
