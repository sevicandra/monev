
<style type="text/css">
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .table-bordered {
        border-collapse: collapse;
        table-layout: fixed;
    }

    .bordered {
        border: 1px solid;
    }

    th,
    td {
        padding: 3.75px 4px;
        font-size: 9px
    }

    th {
        text-align: center;
    }

    td {
        vertical-align: top;
    }
</style>
<page>

    <div style="text-align: center; margin-bottom: 20px">
        <span style="margin: 10px">
            <h1>Daftar Nominatif Pembayaran Honorarium</h1>
        </span>
        <span style="margin: 10px">
            <p>{{ $uraian }}</p>
        </span>
    </div>
    <table class="table-bordered" style="width: 100%; max-width: 100%; margin-bottom: 20px">
        <tr>
            <th class="bordered" style="width:3%">No</th>
            <th class="bordered" style="width: 12%">Nama</th>
            <th class="bordered" style="width: 10%">NIP/NIK/NRP/DLL</th>
            <th class="bordered" style="width: 12%">Dasar Penugasan</th>
            <th class="bordered" style="width: 10%">Jabatan</th>
            <th class="bordered" style="width: 5%">Golongan</th>
            <th class="bordered" style="width: 10%">NPWP</th>
            <th class="bordered" style="width: 5%">Frekuensi</th>
            <th class="bordered" style="width: 5%">Nilai Satuan</th>
            <th class="bordered" style="width: 6%">Bruto</th>
            <th class="bordered" style="width: 6%">Pajak</th>
            <th class="bordered" style="width: 6%">Netto</th>
            <th class="bordered" style="width: 10%">Rekening</th>
        </tr>
        @php
            $no = 1;
            $a= 0;
            $b= 0;
            $c= 0;
        @endphp
        @foreach ($data as $item)
            <tr>
                <td class="bordered" style="text-align: center">{{ $no++ }}</td>
                <td class="bordered">{{ $item->nama }}</td>
                <td class="bordered" style="text-align: center">{{ $item->nip }}</td>
                <td class="bordered">{{ $item->dasar }}</td>
                <td class="bordered">{{ $item->jabatan }}</td>
                <td class="bordered" style="text-align: center">{{ $item->gol }}</td>
                <td class="bordered" style="text-align: center">{{ $item->npwp }}</td>
                <td class="bordered" style="text-align: center">{{ $item->frekuensi }}</td>
                <td class="bordered" style="text-align: right">{{ number_format($item->nilai, 0, ',', '.') }}</td>
                <td class="bordered" style="text-align: right">{{ number_format($item->bruto, 0, ',', '.') }}</td>
                <td class="bordered" style="text-align: right">{{ number_format($item->pajak, 0, ',', '.') }}</td>
                <td class="bordered" style="text-align: right">{{ number_format($item->netto, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: left;">{{ $item->bank }} {{ $item->norek }} a.n. {{ $item->namarek }}</td>
            </tr>
            @php
                $a += $item->bruto;
                $b += $item->pajak;
                $c += $item->netto;
            @endphp
            @endforeach
            <tr>
                <td class="bordered" style="height: 20px; vertical-align: middle; text-align: center; font-weight: bold; font-size: 12px" colspan="9">Total</td>
                <td class="bordered" style="height: 20px; vertical-align: middle; text-align: right">{{ number_format($a, 0, ',', '.') }}</td>
                <td class="bordered" style="height: 20px; vertical-align: middle; text-align: right">{{ number_format($b, 0, ',', '.') }}</td>
                <td class="bordered" style="height: 20px; vertical-align: middle; text-align: right">{{ number_format($c, 0, ',', '.') }}</td>
                <td class="bordered"></td>
            </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 75%">Setuju/Lunas Di Bayar</td>
            <td style="width: 25%">a.n. Kuasa Pengguna Anggaran</td>
        </tr>
        <tr>
            <td style="width: 75%">Bendahara Pengeluaran Kantor Pusat DJKN</td>
            <td style="width: 25%">Pejabat Pembuat Komitmen</td>
        </tr>
        <tr>
            <td style="height: 60px"></td>
            <td style="height: 60px"></td>
        </tr>
        <tr>
            <td style="width: 75%"></td>
            <td style="width: 25%">{{ $ppk }}</td>
        </tr>
    </table>
</page>
