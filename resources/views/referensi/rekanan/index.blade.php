@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Rekanan</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/rekanan/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Search">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Nama Rekanan</x-table.header.column>
                    <x-table.header.column class="border-x">NPWP</x-table.header.column>
                    <x-table.header.column class="border-x">Id Pajak</x-table.header.column>
                    <x-table.header.column class="border-x">Action</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            @switch($item->npwp)
                                @case(1)
                                    YA
                                @break

                                @case(0)
                                    TIDAK
                                @break
                            @endswitch
                        </x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->idpajak }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <div class="join">
                                <a href="/rekanan/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Ubah</a>
                            </div>
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
