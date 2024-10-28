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
        <x-table class="table border-collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border">No</x-table.header.column>
                    <x-table.header.column class="border">SPM</x-table.header.column>
                    <x-table.header.column class="border">SPBy</x-table.header.column>
                    <x-table.header.column class="border">NTPN/SP2D</x-table.header.column>
                    <x-table.header.column class="border">Tanggal NTPN/SP2D</x-table.header.column>
                    <x-table.header.column class="border">NPWP</x-table.header.column>
                    <x-table.header.column class="border">No. NPWP/NIK</x-table.header.column>
                    <x-table.header.column class="border">Rekanan</x-table.header.column>
                    <x-table.header.column class="border">Kode Objek Pajak</x-table.header.column>
                    <x-table.header.column class="border">Tarif</x-table.header.column>
                    <x-table.header.column class="border">PPh</x-table.header.column>
                    <x-table.header.column class="border">NOP</x-table.header.column>
                </tr>
            </x-table.header>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">
                            @if ($item->tagihan->jnstagihan === '1')
                                {{ $item->tagihan->notagihan }}
                            @endif
                        </x-table.body.column>
                        <x-table.body.column class="border">
                            @if ($item->tagihan->jnstagihan === '0')
                                {{ $item->tagihan->notagihan }}
                            @endif
                        </x-table.body.column>
                        @if ($item->tagihan->jnstagihan === '1')
                            <x-table.body.column class="border">
                                {{ $item->tagihan->nomor_sp2d }}
                            </x-table.body.column>
                            <x-table.body.column class="border">
                                {{ $item->tagihan->tanggal_sp2d }}
                            </x-table.body.column>
                        @else
                            <x-table.body.column class="border"> {{ $item->ntpn }} </x-table.body.column>
                            <x-table.body.column class="border">{{ $item->tanggalntpn }}</x-table.body.column>
                        @endif
                        <x-table.body.column class="border">
                            @switch($item->rekanan->npwp)
                                @case(1) Ya @break @default Tidak @endswitch
                        </x-table.body.column>
                        <x-table.body.column class="border">{{ $item->rekanan->idpajak }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->rekanan->nama }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->objekpajak->kode }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->tarif }}%</x-table.body.column>
                        <x-table.body.column class="border">
                            {{ number_format(floor($item->pph * ($item->tarif / 100)), 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
            </tbody>
        </x-table>
    </div>
@endsection
