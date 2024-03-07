@include('partials.header')
@include('partials.sidebar')

<!--**********************************
                Content body start
            ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Reset Database</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <h4>Reset Database</h4>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    @foreach ($tablesWithCount as $table)
                                        <div class="col-xl-3 col-md-6 mb-4 confirm_install cursor">
                                            <div class="card h-100"
                                                @if ($table['count'] > 0) style="background-color: #282a2e;color:white" @endif>
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                                Reset Data</div>
                                                            <div class="h5 mb-0 font-weight-bold"
                                                                @if ($table['count'] > 0) style="color:white" @endif>
                                                                {{ $table['name'] }}
                                                            </div>
                                                            <div class="mt-2 mb-0 text-muted text-xs">
                                                                <span class="mr-2"
                                                                    @if ($table['count'] > 0) style="color:white" @endif><i
                                                                        class="fa fa-server"></i>
                                                                    <span>{{ $table['count'] }}</span></span>
                                                                <span>Data</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fa fa-server fa-2x"
                                                                @if ($table['count'] > 0) style="color:white" @endif></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex w-full"
                                                    @if ($table['count'] > 0) style="background-color: #282a2e;color:white" @endif>
                                                    <form
                                                        action="{{ route('resetTable', ['table' => $table['name']]) }}"
                                                        method="POST" id="resetForm_{{ $table['name'] }}">
                                                        @csrf
                                                        <button type="button" title="Hapus Data"
                                                            class="btn btn-sm btn-danger  @if ($table['count'] > 0) btn-light @endif"
                                                            onclick="resetDatabase('{{ $table['name'] }}')">
                                                            <i class="fa fa-trash"></i> Reset Database
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

<!-- #/ container -->
<!--**********************************
                Content body end
            ***********************************-->
@include('partials.footer')
<script type="text/javascript">
    function resetDatabase(table) {
        Swal.fire({
            title: 'Reset Database?',
            text: "Data yang di reset tidak dapat dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('resetForm_' + table).submit();
            }
        });
    }
</script>
