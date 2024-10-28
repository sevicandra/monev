@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Verifikator {{ $unit->namaunit }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/unit/{{ $unit->id }}/verifikator" class="btn btn-sm btn-neutral"> Kembali</a>
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
                    <x-table.header.column class="border-x">Nama</x-table.header.column>
                    <x-table.header.column class="border-x">NIP</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nip }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <div class="join">
                                <form action="/unit/{{ $unit->id }}/{{ $item->id }}" method="post">
                                    @csrf
                                    <button class="btn btn-xs btn-outline btn-neutral"
                                        onclick="return confirm('Apakah Anda yakin akan menambah role ini ini?');">Tambah</button>
                                </form>
                            </div>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>

    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ $data->links() }}
        </div>
    </div>
@endsection
