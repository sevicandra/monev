<style type="text/css">
    *{
        margin:0;
        padding: 0
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

    #judul2 {
        text-align: center;
        font-size: 13px;
    }

    #judul3 {
        text-align: left;
        font-size: 13px;
    }

    table.page {
        width: 100%;
        border: 1px;
        padding: 1mm;
        font-size: 13px;
    }

    table.detail {
        width: 100%;
        padding: 0mm;
        font-size: 13px;
        border-collapse: collapse;
        border: 1px solid black;
    }

    td.data {
        border: 1px solid black;
        font-size: 11px;
    }

    td.angka {
        border: 1px solid black;
        text-align: right;
        padding-right: 5px;
        font-size: 11px;
    }

    td.head {
        border: 1px solid black;
        font-size: 12px;
    }

    td.headangka {
        border: 1px solid black;
        text-align: right;
        padding-right: 5px;
        font-size: 13px;
    }

    table.detail {
        width: 100%;
        padding: 0mm;
        font-size: 13px;
        border-collapse: collapse;
        border: 1px solid black;
    }
</style>

@php
    $image_path = 'img/logo.jpeg';
    $image_data = base64_encode(file_get_contents($image_path));
    $image_type = pathinfo($image_path, PATHINFO_EXTENSION);
    // Generate data URI
    $src_img = 'data:image/' . $image_type . ';base64,' . $image_data;
@endphp


<page backtop="40mm" backbottom="0mm" backleft="5mm" backright="5mm">

    <page_header>
        <table class="page_header" cellspacing="0px" cellpadding="0px">
            <tr>
                <td class="logo" rowspan="10">
                    <img src="{{ $src_img }}" alt="logo kemenkeu" width="100">
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
                    <b></b><br><br>
                </td>
            </tr>
            <tr>
                <td class="kop3">
                    Gedung Syafrudin Prawiranegara II, Jalan Lapangan Banteng Timur Nomor 2-4, Jakarta 10710
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

    <div id="judul1" style="margin-top: 10px;">
        <strong>REGISTER TAGIHAN</strong><br>
        <span style="font-size: 12px; margin-top: 5px;">No: {{ $register->nomor }} {{ $register->ekstensi }} {{ $register->tahun }}   Tgl: . {{ indonesiaDate($register->created_at) }}</span>
    </div>

    <p style="margin-left:10px; margin-bottom: 10px; margin-top:25px;  text-align: justify;">Saya yang bertandatangan dibawah ini, menyampaikan daftar tagihan sebagai berikut untuk diproses sesuai dengan ketentuan yang berlaku,</p>

    <table class="detail" style="width: 100%; margin-left:3px;">
        <tr style="text-align: center;">
            <td class="head" style="width: 30px; padding: 5px 0">No.</td>
            <td class="head" style="width: 60px; padding: 5px 0">Jenis</td>
            <td class="head" style="width: 55px; padding: 5px 0">Nomor</td>
            <td class="head" style="width: 95px; padding: 5px 0">Tanggal</td>
            <td class="head" style="width: 250px; padding: 5px 0">Uraian</td>
            <td class="head" style="width: 95px; padding: 5px 0">Dokumen</td>
            <td class="head" style="width: 100px; padding: 5px 0">Bruto</td>
        </tr>
            @php
                $i=1;
                $jumlah = 0;
            @endphp
            @foreach ($data as $item)
            <tr>
                <td class="head" style="text-align: center;width: 30px;">{{ $i }}</td>
                <td class="head" style="text-align: center;width: 60px;">
                    @switch($item->jnstagihan)
                        @case(1)
                            SPP
                            @break
                        @case(2)
                            KKP
                            @break
                        @default
                            SPBY
                    @endswitch
                </td>
                <td class="head" style="text-align: center; width: 55px">{{ $item->notagihan }}</td>
                <td class="head" style="text-align: center; width: 95px">{{ indonesiaDate($item->tgltagihan) }}</td>
                <td class="head" style="text-align: justify ;width: 240px; padding: 5px 6px">{{ $item->uraian }}</td>
                <td class="head" style="text-align: center;width: 95px;">{{ $item->dokumen->namadokumen }}</td>
                <td class="head" style="text-align: right;width: 100px; padding-right:6px">{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
            </tr>
            @php
                $i++;
                $jumlah +=$item->realisasi->sum('realisasi');
            @endphp
            @endforeach
        <tr>
            <td class="head" style="text-align: center; padding:5px 0" colspan="6">Jumlah</td>
            <td class="head" style="text-align: right; padding-right:6px">{{ number_format($jumlah, 2, ',', '.') }}</td>
        </tr>
    </table>

    <p style="margin-left:10px; margin-bottom: 5px;  text-align: justify;">Atas kerjasamanya kami ucapkan terima kasih.</p>

    <table style="width: 100%; margin-top: 70px;">
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 35%; text-align: left; margin-top:0; padding-top:0;">Pejabat Pembuat Komitmen</td>
        </tr>
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 35%; text-align: left; margin-top:0; padding-top:0;height:100px"></td>
        </tr>
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 35%; color: RGB(153, 153, 153); margin-top:0; padding-top:0;">Ditandatangani secara elektronik</td>
        </tr>
        <tr>
            <td style="width: 65%;"></td>
            <td style="width: 35%;">{{ $ppk }}</td>
        </tr>
    </table>

</page>