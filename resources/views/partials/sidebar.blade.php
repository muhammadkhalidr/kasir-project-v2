@if (auth()->check())
    @if (auth()->user()->level == 2)
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Data Master</li>
                    <li>
                        <a href="{{ url('home') }}" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('orderan') }}" aria-expanded="false">
                            <i class="icon-basket menu-icon"></i><span class="nav-text">Data Transaksi</span>
                        </a>
                    </li>
                    <hr>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Pembukuan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('jurnal') }}">Jurnal Umum</a></li>
                            <li><a href="{{ url('neraca') }}">Neraca</a></li>
                            <li><a href="{{ url('laba-rugi') }}">Laba Rugi</a></li>
                            <li><a href="{{ url('buku-besar') }}">Buku Besar</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-handbag menu-icon"></i><span class="nav-text">Data Produk</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('produk') }}">Produk</a></li>
                            <li><a href="{{ url('satuan') }}">Satuan</a></li>
                            <li><a href="{{ url('supplier') }}">Supplier</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Bahan & Stok</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('bahan') }}">Data Bahan</a></li>
                            <li><a href="{{ url('kategori') }}">Kategori</a></li>
                            <li><a href="{{ url('datastok') }}">Data Stok</a></li>
                            <li><a href="{{ url('stokmasuk') }}">Stok Masuk</a></li>
                            <li><a href="{{ url('stokkeluar') }}">Stok Keluar</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-book-open menu-icon"></i><span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('pengeluaran') }}">Pengeluaran</a></li>
                            <li><a href="{{ url('pembelian') }}">Pembelian</a></li>
                            {{-- <li><a href="{{ url('hutang') }}">Hutang</a></li> --}}
                            <li><a href="{{ url('pendapatan') }}">Rincian Pendapatan</a></li>
                            <li><a href="{{ url('piutang') }}">Rincian Piutang</a></li>
                            <li><a href="{{ url('omset') }}">Omset Penjualan</a></li>
                            <li><a href="{{ url('aktifitas') }}">Log Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-wallet menu-icon"></i><span class="nav-text">Data Keuangan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('keuangan') }}">Log Keuangan</a></li>
                            <li><a href="{{ url('kas') }}">Data Kas</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-people menu-icon"></i><span class="nav-text">Karyawan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('karyawan') }}">Data Karyawan</a></li>
                            {{-- <li><a href="{{ url('gaji-karyawan') }}">Gaji Karyawan</a></li> --}}
                            <li><a href="{{ url('gaji-karyawanv2') }}">Gaji Karyawan</a></li>
                            <li><a href="{{ url('kasbon') }}">Kasbon Karyawan</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('pelanggan') }}" aria-expanded="false">
                            <i class="icon-user-follow menu-icon"></i><span class="nav-text">Data Pelanggan</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">Pengaturan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('pengguna') }}">Pengguna</a></li>
                            <li><a href="{{ url('setting') }}">Aplikasi</a></li>
                            <li><a href="{{ url('rekening') }}">Rekening</a></li>
                            <li><a href="{{ url('jenis-pengeluaran') }}">Jenis Pengeluaran</a></li>
                            <li><a href="{{ url('menu') }}">Menu Admin</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    @elseif (auth()->user()->level == 3)
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Data Master</li>
                    <li>
                        <a href="{{ url('home') }}" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-basket menu-icon"></i><span class="nav-text">Transaksi</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('orderan') }}">Data Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('pengeluaran') }}">Pengeluaran</a></li>
                            <li><a href="{{ url('pembelian') }}">Pembelian</a></li>
                            <li><a href="{{ url('hutang') }}">Hutang</a></li>
                            <li><a href="{{ url('pendapatan') }}">Rincian Pendapatan</a></li>
                            <li><a href="{{ url('piutang') }}">Rincian Piutang</a></li>
                            <li><a href="{{ url('aktifitas') }}">Log Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Keuangan</li>
                    <li>
                        <a href="{{ url('kas') }}" aria-expanded="false">
                            <i class="icon-wallet menu-icon"></i><span class="nav-text">Kas</span>
                        </a>
                    </li>
                    <li class="nav-label">Pelanggan</li>
                    <li>
                        <a href="{{ url('pelanggan') }}" aria-expanded="false">
                            <i class="icon-wallet people-icon"></i><span class="nav-text">Data Pelanggan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @elseif (auth()->user()->level == 4)
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Data Master</li>
                    <li>
                        <a href="{{ url('dashboard-keuangan') }}" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Pembukuan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('jurnal') }}">Jurnal Umum</a></li>
                            <li><a href="{{ url('neraca') }}">Neraca</a></li>
                            <li><a href="{{ url('laba-rugi') }}">Laba Rugi</a></li>
                            <li><a href="{{ url('buku-besar') }}">Buku Besar</a></li>
                            <li><a href="{{ url('jenis-akun') }}">Jenis Akun</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-wallet menu-icon"></i><span class="nav-text">Data Keuangan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('keuangan') }}">Log Keuangan</a></li>
                            <li><a href="{{ url('kas') }}">Data Kas</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('pengeluaran') }}">Pengeluaran</a></li>
                            <li><a href="{{ url('pembelian') }}">Pembelian</a></li>
                            <li><a href="{{ url('hutang') }}">Hutang</a></li>
                            <li><a href="{{ url('pendapatan') }}">Rincian Pendapatan</a></li>
                            <li><a href="{{ url('piutang') }}">Rincian Piutang</a></li>
                            <li><a href="{{ url('aktifitas') }}">Log Transaksi</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    @elseif (auth()->user()->level == 1)
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <div class="text-center mt-2" style="background-color: #7571f9;color:white;padding:5px">
                    <span>Developer Access</span>
                </div>
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Data Master</li>
                    <li>
                        <a href="{{ url('home') }}" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('orderan') }}" aria-expanded="false">
                            <i class="icon-basket menu-icon"></i><span class="nav-text">Data Transaksi</span>
                        </a>
                    </li>
                    <hr>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Pembukuan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('jurnal-umum') }}">Jurnal Umum</a></li>
                            <li><a href="{{ url('neraca') }}">Neraca</a></li>
                            <li><a href="{{ url('laba-rugi') }}">Laba Rugi</a></li>
                            <li><a href="{{ url('buku-besar') }}">Buku Besar</a></li>
                            <li><a href="{{ url('jenis-akun') }}">Jenis Akun</a></li>

                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-handbag menu-icon"></i><span class="nav-text">Data Produk</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('produk') }}">Produk</a></li>
                            <li><a href="{{ url('satuan') }}">Satuan</a></li>
                            <li><a href="{{ url('supplier') }}">Supplier</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Bahan & Stok</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('bahan') }}">Data Bahan</a></li>
                            <li><a href="{{ url('kategori') }}">Kategori</a></li>
                            <li><a href="{{ url('datastok') }}">Data Stok</a></li>
                            <li><a href="{{ url('stokmasuk') }}">Stok Masuk</a></li>
                            <li><a href="{{ url('stokkeluar') }}">Stok Keluar</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-book-open menu-icon"></i><span class="nav-text">Laporan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('pengeluaran') }}">Pengeluaran</a></li>
                            <li><a href="{{ url('pembelian') }}">Pembelian</a></li>
                            {{-- <li><a href="{{ url('hutang') }}">Hutang</a></li> --}}
                            <li><a href="{{ url('pendapatan') }}">Rincian Pendapatan</a></li>
                            <li><a href="{{ url('piutang') }}">Rincian Piutang</a></li>
                            <li><a href="{{ url('omset') }}">Omset Penjualan</a></li>
                            <li><a href="{{ url('aktifitas') }}">Log Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-wallet menu-icon"></i><span class="nav-text">Data Keuangan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('keuangan') }}">Log Keuangan</a></li>
                            <li><a href="{{ url('kas') }}">Data Kas</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-people menu-icon"></i><span class="nav-text">Karyawan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('karyawan') }}">Data Karyawan</a></li>
                            {{-- <li><a href="{{ url('gaji-karyawan') }}">Gaji Karyawan</a></li> --}}
                            <li><a href="{{ url('gaji-karyawanv2') }}">Gaji Karyawan</a></li>
                            <li><a href="{{ url('kasbon') }}">Kasbon Karyawan</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('pelanggan') }}" aria-expanded="false">
                            <i class="icon-user-follow menu-icon"></i><span class="nav-text">Data Pelanggan</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">Pengaturan</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('pengguna') }}">Pengguna</a></li>
                            <li><a href="{{ url('setting') }}">Aplikasi</a></li>
                            <li><a href="{{ url('rekening') }}">Rekening</a></li>
                            <li><a href="{{ url('jenis-pengeluaran') }}">Jenis Pengeluaran</a></li>
                            <li><a href="{{ url('reset') }}">Reset Data</a></li>
                        </ul>
                    </li>
                    <hr>
                    <li>
                        <a href="{{ url('backup') }}" aria-expanded="false">
                            <i class="fa fa-server menu-icon"></i><span class="nav-text text-info">Backup
                                Database</span>
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="text-center"><span>Versi 1.0</span></div>
            </div>
        </div>
    @endif
@endif
