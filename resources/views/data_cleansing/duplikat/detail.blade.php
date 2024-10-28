@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tagihan Duplikat</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">

        </div>
        <div class="">

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="table collapse w-full">
            <x-table.header class="text-center">
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal</x-table.header.column>
                    <x-table.header.column class="border-x">Uraian</x-table.header.column>
                    <x-table.header.column class="border-x">Unit</x-table.header.column>
                    <x-table.header.column class="border-x">Jenis Dokumen</x-table.header.column>
                    <x-table.header.column class="border-x">Bruto</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">
                            @switch($item->jnstagihan)
                                @case('0')
                                    SPBy
                                @break

                                @case('1')
                                    SPP
                                @break

                                @case('2')
                                    KKP
                                @break
                            @endswitch
                        </x-table.body.column>
                        <x-table.body.column class="border">{{ $item->notagihan }}</x-table.body.column>
                        <x-table.body.column class="border">{{ indonesiaDate($item->tgltagihan) }}</x-table.body.column>
                        <x-table.body.column class="border" style="white-space:normal; min-width:300px">{{ $item->uraian }}</x-table.body.column>
                        <x-table.body.column class="border">{{ optional($item->unit)->namaunit }}</x-table.body.column>
                        <x-table.body.column class="border">{{ optional($item->dokumen)->namadokumen }}</x-table.body.column>
                        <x-table.body.column class="border text-right">
                            Rp{{ number_format(optional($item->realisasi)->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection