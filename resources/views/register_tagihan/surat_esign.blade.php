<style type="text/css">
    *{
        margin:0;
        padding: 0
    }
html { 
    margin: 1.25cm 1.9cm 1.25cm 2.22cm;
    width:21cm;
    height:29.7cm
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
        text-align: left;
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
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
    <table class="page_header" cellspacing="0px" cellpadding="0px">
        <tr>
            <td class="logo" rowspan="10">
                <img src="{{ config('app.url') }}/img/logo.jpeg" alt="logo kemenkeu" width="96">
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
    
    <div id="judul1" style="margin-top: 10px;">
    <strong>REGISTER TAGIHAN</strong><br>
    <span style="font-size: 12px; margin-top: 5px;">No: {{ $register->nomor }} {{ $register->ekstensi }} {{ $register->tahun }}   Tgl: . {{ indonesiaDate($register->created_at) }}</span>
    </div>
    
    <p style="margin-left:10px; margin-bottom: 10px; margin-top:25px;  text-align: justify;">Saya yang bertandatangan dibawah ini, menyampaikan daftar tagihan sebagai berikut untuk diproses sesuai dengan ketentuan yang berlaku,</p>
    
    <table class="detail" style="width: 100%; margin-left:3px;">
    <tr style="text-align: center;">
        <td class="head" style="width: 4%;">No.</td>
        <td class="head" style="width: 7%;">Nomor</td>
        <td class="head" style="width: 18%;">Tanggal</td>
        <td class="head" style="width: 34%;">Uraian</td>
        <td class="head" style="width: 7%;">Jenis</td>
        <td class="head" style="width: 10%;">Unit</td>
        <td class="head" style="width: 10%;">Dokumen</td>
        <td class="head" style="width: 10%;">Bruto</td>
    </tr>
        @php
            $i=1;
        @endphp
        @foreach ($data as $item)
        <tr>
            <td class="head" style="text-align: center;width: 4%;">{{ $i }}</td>
            <td class="head" style="text-align: center;width: 7%;">{{ $item->notagihan }}</td>
            <td class="head" style="width: 18%;">{{ indonesiaDate($item->tgltagihan) }}</td>
            <td class="head" style="width: 34%;">{{ $item->uraian }}</td>
            <td class="head" style="text-align: center;width: 7%;">{{ $item->jnstagihan }}</td>
            <td class="head" style="text-align: center;width: 10%;">{{ $item->unit->namaunit }}</td>
            <td class="head" style="width: 10%;">{{ $item->dokumen->namadokumen }}</td>
            <td class="head" style="text-align: right;width: 10%;">{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
        </tr>
        @php
            $i++
        @endphp
        @endforeach
    <tr>
        <td class="head" style="text-align: center;width: 10%;" colspan="7">Jumlah</td>
        <td class="head" style="text-align: right;width: 10%;"></td>
    </tr>
    </table>
    
    <p style="margin-left:10px; margin-bottom: 5px;  text-align: justify;">Atas kerjasamanya kami ucapkan terima kasih.</p>
    <table style="width: 100%; margin-bottom:0;">
    <tr>
        <td style="width: 65%;"></td>
        <td style="width: 35%; text-align: left; margin-top:0; padding-top:0;"><img src="{{ $qrcode }}" alt=""></td>
    </tr>
    </table>
    <table style="width: 100%;">
    <tr>
        <td style="width: 65%;"></td>
        <td style="width: 35%; color: RGB(153, 153, 153); margin-top:0; padding-top:0;">Ditandatangani secara elektronik</td>
    </tr>
    <tr>
        <td style="width: 65%;"></td>
        <td style="width: 35%;"></td>
    </tr>
    </table>
    
    <table class="page_footer">
    <tr>
        <td class="logo" >
            <img src="{{ config('app.url') }}/img/esign.png" alt="logo bssn" width="20">
        </td>
    </tr>
    </table>
    
</body>
</html>
