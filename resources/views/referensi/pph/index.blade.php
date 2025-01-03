@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPH</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/pph/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div>

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full max-w-2xl">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Kode Golongan</x-table.header.column>
                    <x-table.header.column class="border-x">Tarif PPH</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->kodegolongan }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->tarifpph }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <div class="join">
                                <a href="/pph/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Ubah</a>
                                <form action="/pph/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-error join-item"
                                        onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                </form>
                            </div>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
