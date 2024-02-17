<style type="text/css">
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    table.page_header {
        width: 100%;
        border: none;
        padding: 0mm;
        border-spacing: 0px;
        margin-top: 5px;
        margin-left: 20px;
        align-content: center;
        align-items: center;
        align-self: center;
        box-align: center;
        text-align: center;
    }

    table.page_header_garis {
        width: 100%;
        border: none;
        border-bottom: solid 1mm #77797a;
        padding: 0mm;
        border-spacing: 0px;
        margin-top: 5px;
        margin-left: 20px;
    }

    table.page_footer {
        width: 100%;
        border: none;
        padding: 0mm;
        font-size: 7px;
    }

    td.spd,
    th.spd {
        padding: 1px 5px;
    }

    td.logo {
        text-align: center;
    }

    td.kop1 {
        text-align: center;
        font-size: 17px;
        width: 80%;
    }

    td.kop2 {
        text-align: center;
        font-size: 15px;
    }

    td.kop3 {
        text-align: center;
        font-size: 9px;
        line-height: 7px;
        margin-right: 100px;
    }

    td.garis {
        width: 95%;
        text-align: center;
        font-size: 9px;
        line-height: 7px;
    }

    #judul1 {
        text-align: center;
        font-size: 15px;
    }

    td.rincianBiaya {
        padding: 7.5px 10px;
    }

    th.rincianBiaya {
        text-align: center;
        padding: 7.5px 10px;
    }

    .table-bordered {
        border-collapse: collapse;
        table-layout: fixed;
    }

    .bordered {
        border: 1px solid;
    }
</style>
@php
    use App\Helper\NumberToWord;
    $image_path = 'img/logo.jpeg';
    $image_data = base64_encode(file_get_contents($image_path));
    $image_type = pathinfo($image_path, PATHINFO_EXTENSION);

    $src_img = 'data:image/' . $image_type . ';base64,' . $image_data;
@endphp

@php
    $uangHarians = collect(json_decode($dnp->uangharian));
    $representatifs = collect(json_decode($dnp->representatif));
    $penginapans = collect(json_decode($dnp->penginapan));
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
@endphp


<page backtop="30mm" backbottom="0mm" backleft="5mm" backright="5mm">

    <page_header>
        <table class="page_header" cellspacing="0px" cellpadding="0px">
            <tr>
                <td class="logo" rowspan="10">
                    <img src="{{ $src_img }}" alt="logo kemenkeu" width="80">
                </td>
                <td class="kop1">
                    <b>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</b>
                </td>
            </tr>
            <tr>
                <td class="kop2">
                    <b>DIREKTORAT JENDERAL KEKAYAAN NEGARA</b>
                </td>
            </tr>
            <tr>
                <td class="kop2" style="line-height:1px;">
                    <b></b>
                </td>
            </tr>
            <tr>
                <td class="kop2">

                </td>
            </tr>
            <tr>
                <td class="kop3">
                    GEDUNG SYAFRUDIN PRAWIRANEGARA II LANTAI 5-12
                </td>
            </tr>
            <tr>
                <td class="kop3">
                    JALAN LAPANGAN BANTENG TIMUR NO. 2-4 JAKARTA 10710 KOTAK POS 3169
                </td>
            </tr>
            <tr>
                <td class="kop3">
                    TELEPON (021) 3810162 PSW 4550, FAKSIMILE (021) 3442948, SITUS www.djkn.depkeu.go.id
                </td>
            </tr>
            <tr>
                <td class="kop3">
                </td>
            </tr>
            <tr>
                <td class="kop3">
                </td>
            </tr>
        </table>
        <table class="page_header_garis" cellspacing="0px" cellpadding="0px">
            <tr>
                <td class="garis"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
    </page_footer>
    <div id="judul1" style="margin-bottom: 30px">
        <strong>RINCIAN BIAYA PERJALANAN DINAS</strong><br>
        <span style="font-size: 12px;"></span>
    </div>
    <table>
        <tr>
            <td class="spd">Lampiran SPD Nomor</td>
            <td class="spd">:</td>
            <td class="spd"></td>
        </tr>
        <tr>
            <td class="spd">Tanggal</td>
            <td class="spd">:</td>
            <td class="spd"></td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 20px" class="table-bordered">
        <tr>
            <th class="rincianBiaya bordered" style="width: 8%">No.</th>
            <th class="rincianBiaya bordered" style="width: 50%">Rincian Biaya</th>
            <th class="rincianBiaya bordered" style="width: 21%">Jumlah</th>
            <th class="rincianBiaya bordered" style="width: 21%">Keterangan</th>
        </tr>
        <tr>
            <td class="rincianBiaya bordered" style="text-align: center">1.</td>
            <td class="rincianBiaya bordered">Biaya Angkutan</td>
            <td class="rincianBiaya bordered" style="text-align: right">
                Rp{{ number_format(collect(json_decode($dnp->transport))->sum('nilai'), 0, ',', '.') }}</td>
                @php
                    $a = collect(json_decode($dnp->transport))->sum('nilai');
                @endphp
            <td class="rincianBiaya bordered"></td>
        </tr>
        <tr>
            <td class="rincianBiaya bordered" style="text-align: center">2.</td>
            <td class="rincianBiaya bordered">Transportasi Lain-Lain</td>
            <td class="rincianBiaya bordered" style="text-align: right">
                Rp{{ number_format(collect(json_decode($dnp->transportLain))->sum('nilai'), 0, ',', '.') }}</td>
                @php
                    $b = collect(json_decode($dnp->transportLain))->sum('nilai');
                @endphp
            <td class="rincianBiaya bordered"></td>
        </tr>
        <tr>
            <td class="rincianBiaya bordered"
                style="text-align: center; @if ($uangHarians->count() > 0) border-bottom: 0 @endif">3.</td>
            <td class="rincianBiaya bordered" style="@if ($uangHarians->count() > 0) border-bottom: 0 @endif">
                Satuan Uang Harian/Uang Saku Perjalanan Dinas <br> Selama:</td>
            <td class="rincianBiaya bordered" style="@if ($uangHarians->count() > 0) border-bottom: 0 @endif">
            </td>
            <td class="rincianBiaya bordered" style="@if ($uangHarians->count() > 0) border-bottom: 0 @endif">
            </td>
        </tr>
        @php
            $countUangHarian = 1;
        @endphp
        @foreach ($uangHarians as $uangharian)
            <tr>
                <td class="rincianBiaya"
                    style="text-align: center; border-right: 1px solid; border-left: 1px solid ; @if ($uangHarians->count() == $countUangHarian) border-bottom: 1px solid @endif">
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid ; @if ($uangHarians->count() == $countUangHarian) border-bottom: 1px solid @endif">
                    {{ $uangharian->frekuensi }} Hari x Rp{{ number_format($uangharian->nilai, 0, ',', '.') }}
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid; text-align: right ; @if ($uangHarians->count() == $countUangHarian) border-bottom: 1px solid @endif">
                    Rp{{ number_format($uangharian->frekuensi * $uangharian->nilai, 0, ',', '.') }}
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid; @if ($uangHarians->count() == $countUangHarian) border-bottom: 1px solid @endif">
                    {{ $uangharian->keterangan }}
                </td>
            </tr>
            @php
                $c += $uangharian->frekuensi * $uangharian->nilai;
                $countUangHarian++;
            @endphp
        @endforeach
        <tr>
            <td class="rincianBiaya bordered"
                style="text-align: center; @if ($penginapans->count() > 0) border-bottom: 0 @endif">4.</td>
            <td class="rincianBiaya bordered" style="@if ($penginapans->count() > 0) border-bottom: 0 @endif">Biaya
                Penginapan <br> Selama:</td>
            <td class="rincianBiaya bordered" style="@if ($penginapans->count() > 0) border-bottom: 0 @endif"></td>
            <td class="rincianBiaya bordered" style="@if ($penginapans->count() > 0) border-bottom: 0 @endif"></td>
        </tr>
        @php
            $countPenginapan = 1;
        @endphp
        @foreach ($penginapans as $penginapan)
            <tr>
                <td class="rincianBiaya"
                    style="text-align: center; border-right: 1px solid; border-left: 1px solid ; @if ($penginapans->count() == $countPenginapan) border-bottom: 1px solid @endif">
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid ; @if ($penginapans->count() == $countPenginapan) border-bottom: 1px solid @endif">
                    {{ $penginapan->frekuensi }} Hari x Rp{{ number_format($penginapan->nilai, 0, ',', '.') }}
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid; text-align: right ; @if ($penginapans->count() == $countPenginapan) border-bottom: 1px solid @endif">
                    Rp{{ number_format($penginapan->frekuensi * $penginapan->nilai, 0, ',', '.') }}
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid; @if ($penginapans->count() == $countPenginapan) border-bottom: 1px solid @endif">
                    {{ $penginapan->keterangan }}
                </td>
            </tr>
            @php
                $d += $penginapan->frekuensi * $penginapan->nilai;
                $countPenginapan++;
            @endphp
        @endforeach
        <tr>
            <td class="rincianBiaya bordered"
                style="text-align: center; @if ($representatifs->count() > 0) border-bottom: 0 @endif">5.</td>
            <td class="rincianBiaya bordered" style="@if ($representatifs->count() > 0) border-bottom: 0 @endif">Uang
                Respresentatif <br> Selama:</td>
            <td class="rincianBiaya bordered" style="@if ($representatifs->count() > 0) border-bottom: 0 @endif"></td>
            <td class="rincianBiaya bordered" style="@if ($representatifs->count() > 0) border-bottom: 0 @endif"></td>
        </tr>
        @php
            $countRepresentatif = 1;
        @endphp
        @foreach ($representatifs as $representatif)
            <tr>
                <td class="rincianBiaya"
                    style="text-align: center; border-right: 1px solid; border-left: 1px solid ; @if ($representatifs->count() == $countRepresentatif) border-bottom: 1px solid @endif">
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid ; @if ($representatifs->count() == $countRepresentatif) border-bottom: 1px solid @endif">
                    {{ $representatif->frekuensi }} Hari x Rp{{ number_format($representatif->nilai, 0, ',', '.') }}
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid; text-align: right ; @if ($representatifs->count() == $countRepresentatif) border-bottom: 1px solid @endif">
                    Rp{{ number_format($representatif->frekuensi * $representatif->nilai, 0, ',', '.') }}
                </td>
                <td class="rincianBiaya"
                    style="border-right: 1px solid; border-left: 1px solid; @if ($representatifs->count() == $countRepresentatif) border-bottom: 1px solid @endif">
                    {{ $representatif->keterangan }}
                </td>
            </tr>
            @php
                $e += $representatif->frekuensi * $representatif->nilai;
                $countRepresentatif++;
            @endphp
        @endforeach
        <tr>
            <td colspan="2" class="rincianBiaya bordered">Total</td>
            <td class="bordered rincianBiaya" style="text-align: right">Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.') }}</td>
            <td class="bordered rincianBiaya"></td>
        </tr>
        <tr>
            <td colspan="4" class="rincianBiaya bordered">Terbilang: {{ NumberToWord::toWords($a + $b + $c + $d + $e) }} Rupiah</td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 20px">
        <tr>
            <td style="width: 35%"></td>
            <td style="width: 30%"></td>
            <td style="width: 35%">Jakarta,</td>
        </tr>
        <tr>
            <td>Telah Dibayar Sejumlah</td>
            <td></td>
            <td>Telah Menerima Jumlah Uang Sebesar</td>
        </tr>
        <tr>
            <td>Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.')}}</td>
            <td></td>
            <td>Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.')}}</td>
        </tr>
        <tr>
            <td style="height: 80px"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $dnp->nama }}</td>
        </tr>
        <tr>
            <td>NIP.</td>
            <td></td>
            <td>NIP. {{ $dnp->nip }}</td>
        </tr>
    </table>
    <table class="page_header_garis" cellspacing="0px" cellpadding="0px" style="margin-left: 0px; width: 190mm;">
        <tr>
            <td class="garis"></td>
        </tr>
    </table>
    <table style="margin-top: 20px">
        <tr>
            <th class="spd" colspan="3">PERHITUNGAN SPD RAMPUNG</th>
        </tr>
        <tr>
            <td class="spd">Ditetapkan</td>
            <td class="spd">:</td>
            <td class="spd">Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.')}}</td>
        </tr>
        <tr>
            <td class="spd">Yang Telah Dibayarkan Ditetapkan</td>
            <td class="spd">:</td>
            <td class="spd"></td>
        </tr>
        <tr>
            <td class="spd">Sisa Kurang</td>
            <td class="spd">:</td>
            <td class="spd"></td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 40px">
        <tr>
            <td style="width: 65%"></td>
            <td>Pejabat Pembuat Komitmen</td>
        </tr>
        <tr>
            <td style="width: 65%"></td>
            <td style="height: 80px"></td>
        </tr>
        <tr>
            <td style="width: 65%"></td>
            <td>{{ $ppk->nama }}</td>
        </tr>
        <tr>
            <td style="width: 65%"></td>
            <td>NIP. {{ $ppk->nip }}</td>
        </tr>
    </table>
</page>
