@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Verifikator {{ $data->namaunit }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/unit" class="btn btn-sm btn-neutral"> Kembali</a>
            <a href="/unit/{{ $data->id }}/verifikator/create" class="btn btn-sm btn-neutral"> Tambah
                Verifikator</a>
        </div>
        <div>

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
            <tbody>
                @foreach ($data->verifikator()->get() as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nip }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <div class="join">
                                <form action="/unit/{{ $data->id }}/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-error "
                                        onclick="return confirm('Apakah Anda yakin akan menghapus role ini?');">Hapus</button>
                                </form>
                            </div>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </tbody>
        </x-table>
    </div>
@endsection
