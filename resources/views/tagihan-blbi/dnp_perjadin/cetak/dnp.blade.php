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
            <h1>Daftar Nominatif Perjalanan Dinas</h1>
        </span>
        <span style="margin: 10px">
            <p>{{ $uraian }}</p>
        </span>
    </div>
    <table class="table-bordered" style="width: 100%; max-width: 100%; margin-bottom: 20px">
        <tr>
            <th class="bordered" style="width:3%">No</th>
            <th class="bordered" style="width:7%">Nama</th>
            <th class="bordered" style="width:10%">NIP/NIK/NRP/DLL</th>
            <th class="bordered" style="width:7%">Unit Kerja</th>
            <th class="bordered" style="width:8%">Surat Tugas</th>
            <th class="bordered" style="width:8%">Lokasi <br> (Asal - Tujuan)</th>
            <th class="bordered" style="width:8%">Durasi</th>
            <th class="bordered" style="width:7%">Uang Harian</th>
            <th class="bordered" style="width:7%">Uang Representatif</th>
            <th class="bordered" style="width:7%">Transport</th>
            <th class="bordered" style="width:7%">Transport Lain-Lain</th>
            <th class="bordered" style="width:7%">Hotel</th>
            <th class="bordered" style="width:7%">Netto</th>
            <th class="bordered" style="width:7%">Rekening</th>
        </tr>
        @php
            $no = 1;
            $total= 0;
        @endphp
        @foreach ($data as $item)
            @php
                $a = collect(json_decode($item->transport))->sum('nilai');
                $b = collect(json_decode($item->transportLain))->sum('nilai');
                $c = 0;
                $d = 0;
                $e = 0;
            @endphp

            @foreach (collect(json_decode($item->uangharian)) as $uangharian)
                @php
                    $c += $uangharian->frekuensi * $uangharian->nilai;
                @endphp
            @endforeach

            @foreach (collect(json_decode($item->penginapan)) as $penginapan)
                @php
                    $d += $penginapan->frekuensi * $penginapan->nilai;
                @endphp
            @endforeach

            @foreach (collect(json_decode($item->representatif)) as $representatif)
                @php
                    $e += $representatif->frekuensi * $representatif->nilai;
                @endphp
            @endforeach
            @php
                $total += $a + $b + $c + $d + $e;
            @endphp
            <tr>
                <td class="bordered" style="width:3%; text-align: center;">{{ $no++ }}.</td>
                <td class="bordered" style="width:7%; text-align: left;">{{ $item->nama }}</td>
                <td class="bordered" style="width:10%; text-align: center;">{{ $item->nip }}</td>
                <td class="bordered" style="width:7%; text-align: center;">{{ $item->unit }}</td>
                <td class="bordered" style="width:7%; text-align: center;">{{ $item->st }}</td>
                <td class="bordered" style="width:7%; text-align: center;">{{ $item->lokasi }}</td>
                <td class="bordered" style="width:7%; text-align: center;">{{ $item->durasi }}</td>
                <td class="bordered" style="width:7%; text-align: right;">Rp{{ number_format($c, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: right;">Rp{{ number_format($e, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: right;">Rp{{ number_format($a, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: right;">Rp{{ number_format($b, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: right;">Rp{{ number_format($d, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: right;">Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.') }}</td>
                <td class="bordered" style="width:7%; text-align: left;">{{ $item->bank }} {{ $item->norek }} a.n. {{ $item->namarek }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="12" class="bordered" style="height: 20px; text-align: center; vertical-align: middle">Total</td>
            <td class="bordered" style="height: 20px; text-align: right; vertical-align: middle">Rp{{ number_format($total, 0, ',', '.') }}</td>
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
