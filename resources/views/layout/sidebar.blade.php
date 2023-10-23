
    <div class="pt-3 d-flex flex-column justify-content-between pb-3 h-100 max-h-100 overflow-auto">
        <div>
            {{--  Halaman Utama  --}}
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span>Halaman Utama</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/dashboard">
                        &nbsp; Dashboard
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/dashboard/unit">
                        &nbsp; Realisasi Unit
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/dashboard/ppk">
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
                    <a class="nav-link pb-1 text-muted" href="/tagihan">
                        &nbsp; Data Tagihan
                    </a>
                </li>
                @endcan
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/register">
                        &nbsp; Register Tagihan
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/monitoring-tagihan">
                        &nbsp; Arsip Tagihan
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/arsip-register">
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
                    <a class="nav-link pb-1 text-muted" href="/verifikasi">
                        &nbsp; Verifikasi
                    </a>
                </li>
                @endcan
                @can('PPSPM', auth()->user()->id)
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/ppspm">
                        &nbsp; PPSPM
                    </a>
                </li>
                @endcan
                @can('Bendahara', auth()->user()->id)
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/bendahara">
                        &nbsp; Bendahara
                    </a>
                </li>
                @endcan
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/arsip">
                        &nbsp; Arsip Tagihan
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/arsip-register">
                        &nbsp; Arsip Register
                    </a>
                </li>
                <li class="nav-item m-0 p-0">
                    <a class="nav-link pb-1 text-muted" href="/laporan-pajak">
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
                    <a class="nav-link pb-1 text-muted" href="/referensi">
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
