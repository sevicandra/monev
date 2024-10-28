@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content"> Rekap PPN </h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/laporan-pajak/pph" class="btn btn-sm btn-neutral">PPh</a>
            <a href="/laporan-pajak/ppn" class="btn btn-sm btn-neutral">PPN</a>
        </div>
        <div class="col-lg-5">
        </div>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            @for ($i = 1; $i < 13; $i++)
                <a href="/laporan-pajak/ppn?bulan={{ $i }}" class="btn btn-sm btn-neutral">{{ $i }}</a>
            @endfor
        </div>
        <div>
            @if (request('bulan'))
                <a href="/laporan-pajak/ppn/cetak?bulan={{ request('bulan') }}" class="btn btn-sm btn-neutral">cetak</a>
            @endif
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">SPM</x-table.header.column>
                    <x-table.header.column class="border-x">SPBy</x-table.header.column>
                    <x-table.header.column class="border-x">NTPN/SP2D</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal NTPN/SP2D</x-table.header.column>
                    <x-table.header.column class="border-x">No. NPWP</x-table.header.column>
                    <x-table.header.column class="border-x">Rekanan</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor Faktur Pajak</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal Faktur Pajak</x-table.header.column>
                    <x-table.header.column class="border-x">Tarif</x-table.header.column>
                    <x-table.header.column class="border-x">PPh</x-table.header.column>
                    <x-table.header.column class="border-x">NOP</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
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
                                {{ indonesiaDate($item->tagihan->tanggal_sp2d) }}
                            </x-table.body.column>
                        @else
                            <x-table.body.column class="border"> {{ $item->ntpn }}
                            </x-table.body.column>
                            <x-table.body.column
                                class="border">{{ $item->tanggalntpn }}</x-table.body.column>
                        @endif
                        <x-table.body.column
                            class="border">{{ $item->rekanan->idpajak }}</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ $item->rekanan->nama }}</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ $item->nomorfaktur }}</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ indonesiaDate($item->tanggalfaktur) }}</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ $item->tarif * 100 }}%</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ number_format(floor($item->ppn * $item->tarif), 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ number_format($item->ppn, 2, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
