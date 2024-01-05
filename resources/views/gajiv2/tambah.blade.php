@include('partials.header')
@include('partials.sidebar')


<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $breadcrumb }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mb-4"> <i class="fa fa-arrow-left"
                                onclick="window.location='{{ url('gajikaryawanv2') }}'" style="cursor: pointer"></i>
                            Gaji Karyawan</h2>
                        {{-- <div class="settings">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#settingHargaKerja"><i class="fa fa-cog"></i></button>
                        </div> --}}
                        <div class="form-validation">
                            <form class="form-valide" action="{{ url('gajikaryawanv2') }}" method="POST">
                                @csrf
                                <input type="hidden" name="txtid">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="txtnama">Nama Karyawan <span
                                            class="text-danger">*</span>
                                    </label>

                                    <div class="col-lg-6">
                                        <select name="txtidkaryawan" id="txtidkaryawan"
                                            class="form-control @error('txtidkaryawan')
                                        is-invalid
                                        @enderror">
                                            <option value="" selected>Pilih Karyawan</option>
                                            @foreach ($karyawans as $n)
                                                <option value="{{ $n->id_karyawan }}"
                                                    {{ old('txtidkaryawan') == $n->nama_karyawan ? 'selected' : '' }}>
                                                    {{ $n->nama_karyawan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('txtidkaryawan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="txtjumlahgaji">Jumlah Gaji<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                            class="form-control rupiah @error('txtjumlahgaji')
                                        is-invalid
                                        @enderror"
                                            id="txtjumlahgaji" name="txtjumlahgaji" value="{{ old('txtjumlahgaji') }}">
                                        @error('txtjumlahgaji')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="txtpersen">% Bonus<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                            class="form-control @error('txtpersen')
                                        is-invalid
                                        @enderror"
                                            id="txtpersen" name="txtpersen" value="{{ old('txtpersen') }}">
                                        @error('txtpersen')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="txtbonus">Jumlah Bonus<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                            class="form-control @error('txtbonus')
                                        is-invalid
                                        @enderror"
                                            id="txtbonus" name="txtbonus" value="{{ old('txtbonus') }}">
                                        @error('txtbonus')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
    {{-- Modal --}}
    {{-- <div class="modal fade" id="settingHargaKerja">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setting</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <label for="hargaKerja">Harga Kerja:</label>
                    <input type="number" id="hargaKerja" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button id="updateButton" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div> --}}

</div>

<!--**********************************
            Content body end
        ***********************************-->
@include('partials.footer')

<script>
    function calculateBonus() {
        // Get input values
        var jumlahGaji = parseFloat(document.getElementById('txtjumlahgaji').value.replace(/\./g, '').replace(/,/g,
            '.')) || 0;
        var persenBonus = parseFloat(document.getElementById('txtpersen').value) || 0;

        // Calculate bonus
        var bonus = Math.round((jumlahGaji * persenBonus) / 100);

        // Display bonus in the 'txtbonus' input field
        document.getElementById('txtbonus').value = bonus.toLocaleString(); // Menampilkan bonus dengan format rupiah
    }

    // Attach the function to the 'blur' event of 'txtjumlahgaji' and 'txtpersen'
    document.getElementById('txtjumlahgaji').addEventListener('blur', calculateBonus);
    document.getElementById('txtpersen').addEventListener('blur', calculateBonus);

    $(document).ready(function() {
        $('.rupiah').mask("#.##0", {
            reverse: true
        });
    });
</script>
