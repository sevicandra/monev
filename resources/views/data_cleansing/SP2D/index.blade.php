@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">SP2D Duplikat</h1>
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
        <x-table class="collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor SP2D</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal SP2D</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr class="text-center">
                        <x-table.body.column class="border">{{ $loop->iteration }}</x-table.body.column>
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
                        <x-table.body.column class="border">{{ $item->nomor_sp2d }}</x-table.body.column>
                        <x-table.body.column class="border">{{ indonesiaDate($item->tanggal_sp2d) }}</x-table.body.column>
                        <x-table.body.column class="border">
                            <form action="/cleansing/sp2d/{{ $item->id }}" method="post"
                                onsubmit="return confirm('Apakah anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-error btn-outline">Hapus</button>
                            </form>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
