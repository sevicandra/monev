@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Rekap PPh</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/laporan-pajak/pph" class="btn btn-sm btn-neutral">PPh</a>
            <a href="/laporan-pajak/ppn" class="btn btn-sm btn-neutral">PPN</a>
        </div>
        <div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            @for ($i = 1; $i < 13; $i++)
                <a href="/laporan-pajak/pph?bulan={{ $i }}" class="btn btn-sm btn-neutral">{{ $i }}</a>
            @endfor
        </div>
        <div>
            @if (request('bulan'))
                <a href="/laporan-pajak/pph/cetak?bulan={{ request('bulan') }}" class="btn btn-sm btn-neutral">cetak</a>
            @endif
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">SPM</th>
                    <th class="border border-base-content">SPBy</th>
                    <th class="border border-base-content">NTPN/SP2D</th>
                    <th class="border border-base-content">Tanggal NTPN/SP2D</th>
                    <th class="border border-base-content">NPWP</th>
                    <th class="border border-base-content">No. NPWP/NIK</th>
                    <th class="border border-base-content">Rekanan</th>
                    <th class="border border-base-content">Kode Objek Pajak</th>
                    <th class="border border-base-content">Tarif</th>
                    <th class="border border-base-content">PPh</th>
                    <th class="border border-base-content">NOP</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content">{{ $i }}</td>
                        <td class="border border-base-content">
                            @if ($item->tagihan->jnstagihan === '1')
                                {{ $item->tagihan->notagihan }}
                            @endif
                        </td>
                        <td class="border border-base-content">
                            @if ($item->tagihan->jnstagihan === '0')
                                {{ $item->tagihan->notagihan }}
                            @endif
                        </td>
                        @if ($item->tagihan->jnstagihan === '1')
                            <td class="border border-base-content">
                                {{ $item->tagihan->nomor_sp2d }}
                            </td>
                            <td class="border border-base-content">
                                {{ $item->tagihan->tanggal_sp2d }}
                            </td>
                        @else
                            <td class="border border-base-content"> {{ $item->ntpn }} </td>
                            <td class="border border-base-content">{{ $item->tanggalntpn }}</td>
                        @endif
                        <td class="border border-base-content">
                            @switch($item->rekanan->npwp)
                                @case(1) Ya @break @default Tidak @endswitch
                        </td>
                        <td class="border border-base-content">{{ $item->rekanan->idpajak }}</td>
                        <td class="border border-base-content">{{ $item->rekanan->nama }}</td>
                        <td class="border border-base-content">{{ $item->objekpajak->kode }}</td>
                        <td class="border border-base-content">{{ $item->tarif }}%</td>
                        <td class="border border-base-content">
                            {{ number_format(floor($item->pph * ($item->tarif / 100)), 2, ',', '.') }}</td>
                        <td class="border border-base-content">{{ number_format($item->pph, 2, ',', '.') }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
