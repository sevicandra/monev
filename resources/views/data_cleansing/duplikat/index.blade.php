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
        <x-table class="collapse w-full max-w-md">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Jumlah Duplikat</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
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
                        <x-table.body.column class="border text-center">{{ $item->notagihan }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->jml }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <a href="/cleansing/duplikat/{{ $item->jnstagihan }}/{{ $item->notagihan }}" class="btn btn-xs btn-neutral">Detail</a>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection