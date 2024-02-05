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
                </ul>
            </details>
        </li>
        {{--  Akhir Halaman Utama  --}}
        {{--  Pejabat Pembuat Komitmen  --}}
        @canany(['PPK', 'Staf_PPK'], auth()->user()->id)
            <li>
                <details open>
                    <summary>Pejabat Komitmen</summary>
                    <ul>
                        @can('Staf_PPK', auth()->user()->id)
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
                        @can('Staf_PPK', auth()->user()->id)
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

        @canany(['PPSPM', 'Bendahara', 'Validator'], auth()->user()->id)
            {{--  Bagian Keuangan  --}}
            <li>
                <details open>
                    <summary>Bagian Keuangan</summary>
                    <ul>
                        @can('Validator', auth()->user()->id)
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
                        @can('ValidatorKKP', auth()->user()->id)
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
                        @can('PPSPM', auth()->user()->id)
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
                        @can('Bendahara', auth()->user()->id)
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
                    </ul>
                </details>
            </li>
            {{--  Akhir Bagian Keuangan  --}}
        @endcanany
        @canany(['admin_satker', 'sys_admin', 'KPA', 'Staf_KPA'], auth()->user()->id)
            {{--  Admin  --}}
            <li>
                <details close>
                    <summary>Referensi</summary>
                    <ul>
                        @canany(['sys_admin', 'admin_satker'], auth()->user()->id)
                            <li><a href="/user">Users</a></li>
                            <li><a href="/nomor">Nomor</a></li>
                        @endcan
                        @can('admin_satker', auth()->user()->id)
                            <li><a href="/unit">Unit</a></li>
                            <li><a href="/maping-ppk">Maping PPK</a></li>
                            <li><a href="/maping-staf-ppk">Maping Staf PPK</a></li>
                        @endcan

                        @canany(['Staf_KPA', 'KPA'], auth()->user()->id)
                            <li><a href="/pagu">Pagu</a></li>
                        @endcanany
                        @can('sys_admin', auth()->user()->id)
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
        @canany(['admin_satker', 'sys_admin'], auth()->user()->id)
            {{--  Admin  --}}
            <li>
                <details close>
                    <summary>Data Cleansing</summary>
                    <ul>
                        @canany(['sys_admin', 'admin_satker'], auth()->user()->id)
                            <li><a href="/cleansing/tagihan">Tagihan</a></li>
                            <li><a href="/cleansing/sp2d">SP2D</a></li>
                            <li><a href="/cleansing/spby">SPBy</a></li>
                            <li><a href="/cleansing/kkp">KKP</a></li>
                            <li><a href="/cleansing/spp">SPP</a></li>
                        @endcan
                    </ul>
                </details>
            </li>
            {{--  Akhir Admin  --}}
        @endcanany
        <li class="">Version : 2.3.1</li>
    </menu>
</div>
{{--  Halaman Utama  --}}
