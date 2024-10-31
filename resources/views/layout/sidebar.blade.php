<div class="menu">
    <menu>
        <li>
            <details open>
                <summary>Halaman Utama</summary>
                <ul>
                    <li>
                        <a href="/dashboard">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/unit">
                            Realisasi Unit
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/ppk">
                            Realisasi PPK
                        </a>
                    </li>
                    <li>
                        <a href="/tracking">
                            Tracking Payroll
                        </a>
                    </li>
                </ul>
            </details>
        </li>
        {{--  Akhir Halaman Utama  --}}
        {{--  Pejabat Pembuat Komitmen  --}}
        @canany(['PPK', 'Staf_PPK'])
            <li>
                <details open>
                    <summary>Pejabat Komitmen</summary>
                    <ul>
                        @can('Staf_PPK')
                            <li>
                                <a href="/tagihan">
                                    Data Tagihan
                                    @if (isset($notifikasi->tagihan) && $notifikasi->tagihan > 0)
                                        @if ($notifikasi->tagihan > 99)
                                            <div class="badge badge-primary">99+</div>
                                        @else
                                            <div class="badge badge-primary">{{ $notifikasi->tagihan }}</div>
                                        @endif
                                    @endif
                                </a>
                            </li>
                            @if (session()->get('staf_ppk_blbi') == 1)
                                <li>
                                    <a href="/tagihan-blbi">
                                        Data Tagihan BLBI
                                        @if (isset($notifikasi->tagihanBlbi) && $notifikasi->tagihanBlbi > 0)
                                            @if ($notifikasi->tagihanBlbi > 99)
                                                <div class="badge badge-primary">99+</div>
                                            @else
                                                <div class="badge badge-primary">{{ $notifikasi->tagihanBlbi }}</div>
                                            @endif
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endcan
                        {{-- <li>
                            <a href="/register">
                                Register Tagihan
                            </a>
                        </li> --}}
                        <li>
                            <a href="/monitoring-tagihan">
                                Arsip Tagihan
                            </a>
                        </li>
                        {{-- <li>
                            <a href="/arsip-register">
                                Arsip Register
                            </a>
                        </li> --}}
                        {{--  Akhir Pejabat Pembuat Komitmen  --}}
                        @can('Staf_PPK')
                            <li>
                                <details close>
                                    <summary>Referensi</summary>
                                    <ul>
                                        <li><a href="/referensi-rekening">Rekening</a></li>
                                        <li><a href="/rekanan">Rekanan</a></li>
                                    </ul>
                                </details>
                            </li>
                        @endcan
                    </ul>
                </details>
            </li>
        @endcanany

        @canany(['PPSPM', 'Bendahara', 'Validator'])
            {{--  Bagian Keuangan  --}}
            <li>
                <details open>
                    <summary>Bagian Keuangan</summary>
                    <ul>
                        @can('Validator')
                            <li>
                                <a href="/verifikasi">
                                    Verifikasi
                                    @if (isset($notifikasi->verifikasi) && $notifikasi->verifikasi > 0)
                                        @if ($notifikasi->verifikasi > 99)
                                            <div class="badge badge-primary">99+</div>
                                        @else
                                            <div class="badge badge-primary">{{ $notifikasi->verifikasi }}</div>
                                        @endif
                                    @endif
                                </a>
                            </li>
                        @endcan
                        @can('ValidatorKKP')
                            <li>
                                <a href="/verifikasi-kkp">
                                    Verifikasi KKP
                                    @if (isset($notifikasi->verifikasiKKP) && $notifikasi->verifikasiKKP > 0)
                                        @if ($notifikasi->verifikasiKKP > 99)
                                            <div class="badge badge-primary">99+</div>
                                        @else
                                            <div class="badge badge-primary">{{ $notifikasi->verifikasiKKP }}</div>
                                        @endif
                                    @endif
                                </a>
                            </li>
                        @endcan
                        @can('PPSPM')
                            <li>
                                <a href="/ppspm">
                                    PPSPM
                                    @if (isset($notifikasi->ppspm) && $notifikasi->ppspm > 0)
                                        @if ($notifikasi->ppspm > 99)
                                            <div class="badge badge-primary">99+</div>
                                        @else
                                            <div class="badge badge-primary">{{ $notifikasi->ppspm }}</div>
                                        @endif
                                    @endif
                                </a>
                            </li>
                        @endcan
                        @can('Bendahara')
                            <li>
                                <a href="/payroll">
                                    Payroll
                                    @if (isset($notifikasi->payroll) && $notifikasi->payroll > 0)
                                        @if ($notifikasi->payroll > 99)
                                            <div class="badge badge-primary">99+</div>
                                        @else
                                            <div class="badge badge-primary">{{ $notifikasi->payroll }}</div>
                                        @endif
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="/bendahara">
                                    Bendahara
                                    @if (isset($notifikasi->bendahara) && $notifikasi->bendahara > 0)
                                        @if ($notifikasi->bendahara > 99)
                                            <div class="badge badge-primary">99+</div>
                                        @else
                                            <div class="badge badge-primary">{{ $notifikasi->bendahara }}</div>
                                        @endif
                                    @endif
                                </a>
                            </li>
                        @endcan
                        <li>
                            <a href="/arsip">
                                Arsip Tagihan
                            </a>
                        </li>
                        {{-- <li>
                            <a href="/arsip-register">
                                Arsip Register
                            </a>
                        </li> --}}
                        <li>
                            <a href="/laporan-pajak">
                                Laporan Pajak
                            </a>
                        </li>
                        <li>
                            <a href="/rekap-payroll">
                                Rekap Payroll
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            {{--  Akhir Bagian Keuangan  --}}
        @endcanany
        @canany(['admin_satker', 'sys_admin', 'KPA', 'Staf_KPA'])
            {{--  Admin  --}}
            <li>
                <details close>
                    <summary>Referensi</summary>
                    <ul>
                        @canany(['sys_admin', 'admin_satker'])
                            <li><a href="/user">Users</a></li>
                            <li><a href="/nomor">Nomor</a></li>
                        @endcan
                        @can('admin_satker')
                            <li><a href="/unit">Unit</a></li>
                            <li><a href="/maping-ppk">Maping PPK</a></li>
                            <li><a href="/maping-staf-ppk">Maping Staf PPK</a></li>
                        @endcan

                        @canany(['Staf_KPA', 'KPA'])
                            <li><a href="/pagu">Pagu</a></li>
                        @endcanany
                        @can('sys_admin')
                            <li><a href="/satker">Satuan Kerja</a></li>
                            <li><a href="/dokumen">Jenis Dokumen</a></li>
                            <li><a href="/tahun">Tahun Anggaran</a></li>
                            <li><a href="/berkas">Berkas</a></li>
                            <li><a href="/pph">PPH</a></li>
                            <li><a href="/bulan">Bulan</a></li>
                            <li><a href="/role">Role</a></li>
                            <li><a href="/referensi/objek-pajak">Objek Pajak</a></li>
                        @endcan
                    </ul>
                </details>
            </li>
            {{--  Akhir Admin  --}}
        @endcanany
        @canany(['admin_satker', 'sys_admin'])
            {{--  Admin  --}}
            <li>
                <details close>
                    <summary>Data Cleansing</summary>
                    <ul>
                        @canany(['sys_admin', 'admin_satker'])
                            <li><a href="/cleansing/tagihan">Tagihan</a></li>
                            <li><a href="/cleansing/duplikat">Duplikat</a></li>
                            {{-- <li><a href="/cleansing/sp2d">SP2D</a></li> --}}
                            <li><a href="/cleansing/spby">SPBy</a></li>
                            <li><a href="/cleansing/kkp">KKP</a></li>
                            <li><a href="/cleansing/spp">SPP</a></li>
                            <li><a href="/cleansing/spm">SPM</a></li>
                            <li><a href="/cleansing/realisasi-bulanan">Realisasi</a></li>
                            <li><a href="/cleansing/rekap-spm">Rekap SPM</a></li>
                        @endcan
                    </ul>
                </details>
            </li>
            {{--  Akhir Admin  --}}
        @endcanany
        <li class="">Version : 2.9.1</li>
    </menu>
</div>
{{--  Halaman Utama  --}}
