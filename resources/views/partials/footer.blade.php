<!--**********************************
            Footer start
        ***********************************-->
<div class="footer">
    <div class="copyright">
        {!! env('FOOTER_NAME') !!}
    </div>
</div>
<!--**********************************
            Footer end
        ***********************************-->
</div>
<!--**********************************
        Main wrapper end
    ***********************************-->

<!--**********************************
        Scripts
    ***********************************-->

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script src="{{ asset('/') }}assets/plugins/common/common.min.js"></script>
<script src="{{ asset('/') }}assets/js/custom.min.js"></script>
<script src="{{ asset('/') }}assets/js/settings.js"></script>
<script src="{{ asset('/') }}assets/js/gleek.js"></script>
<script src="{{ asset('/') }}assets/js/styleSwitcher.js"></script>
<script src="{{ asset('/') }}assets/plugins/toastr/js/toastr.min.js"></script>
<script src="{{ asset('/') }}assets/plugins/toastr/js/toastr.init.js"></script>
<script src="{{ asset('/') }}assets/plugins/tables/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/') }}assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('/') }}assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
<script src="{{ asset('/') }}assets/js/plugins-init/jfsc.js"></script>
<script src="{{ asset('/') }}assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ asset('/') }}assets/js/hitung.js"></script>
<script src="{{ asset('/') }}assets/js/hitungGaji.js"></script>
<script src="{{ asset('/') }}assets/js/hitungPengeluaran.js"></script>
<script src="{{ asset('/') }}assets/js/jquery.mask.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('/') }}assets/js/transaksi.js"></script>
<script src="{{ asset('/') }}assets/js/pembelian.js"></script>

@if (Session::has('error'))
    <script>
        swal.fire('Peringatan!!', '{{ Session::get('error') }}', 'warning');
    </script>
@endif
@if (Session::has('success'))
    <script>
        swal.fire('Success!', '{{ Session::get('success') }}', 'success');
    </script>
@endif

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/65ce61c29131ed19d96d3874/1hmn2robn';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->

</body>

</html>
