<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 d-flex flex-column justify-content-between pb-3 h-100">
        <div>
            {{--  Halaman Utama  --}}
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span>Halaman Utama</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/dashboard">
                        &nbsp; Dashboard
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/dashboard/unit">
                        &nbsp; Realisasi Unit
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/dashboard/ppk">
                        &nbsp; Realisasi PPK
                    </a>
                </li>
            </ul>
            {{--  Akhir Halaman Utama  --}}
            {{--  Pejabat Pembuat Komitmen  --}}
            @canany(['PPK', 'Staf_PPK'], auth()->user()->id)            
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span>Pejabat Pembuat Komitmen</span>
            </h6>
            <ul class="nav flex-column">
                @can('Staf_PPK', auth()->user()->id)
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/tagihan">
                        &nbsp; Data Tagihan
                    </a>
                </li>
                @endcan
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/register">
                        &nbsp; Register Tagihan
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/monitoring-tagihan">
                        &nbsp; Arsip Tagihan
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/arsip-register">
                        &nbsp; Arsip Register
                    </a>
                </li>
            </ul>
            @endcanany
            {{--  Akhir Pejabat Pembuat Komitmen  --}}
            
            @canany(['PPSPM', 'Bendahara', 'Validator'], auth()->user()->id)
            {{--  Bagian Keuangan  --}}
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span>Bagian Keuangan</span>
            </h6>
            <ul class="nav flex-column">
                @can('Validator', auth()->user()->id)
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/verifikasi">
                        &nbsp; Verifikasi
                    </a>
                </li>
                @endcan
                @can('PPSPM', auth()->user()->id)
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/ppspm">
                        &nbsp; PPSPM
                    </a>
                </li>
                @endcan
                @can('Bendahara', auth()->user()->id)
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/bendahara">
                        &nbsp; Bendahara
                    </a>
                </li>
                @endcan
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/arsip">
                        &nbsp; Arsip Tagihan
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/arsip-register">
                        &nbsp; Arsip Register
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/laporan-pajak">
                        &nbsp; Laporan Pajak
                    </a>
                </li>
            </ul>
            {{--  Akhir Bagian Keuangan  --}}
            @endcanany
            @canany(['admin_satker', 'sys_admin', 'KPA', 'Staf_KPA', 'PPK', 'Staf_PPK'], auth()->user()->id)
            {{--  Admin  --}}
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span>Admin</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1" href="/referensi">
                        &nbsp; Referensi
                    </a>
                </li>
            </ul>
            {{--  Akhir Admin  --}}
            @endcanany
    
            <form action="/logout" method="post">
                @csrf
                <button class="btn btn-sm btn-outline-info mt-3 ml-4">Keluar Aplikasi</button>
            </form>
        </div>

        <div>
            <span class="px-3">
                Version : 2.2.0
            </span>
        </div>
    </div>
</nav>