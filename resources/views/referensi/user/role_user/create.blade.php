@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Role {{ $user->nama }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/role-user/{{ $user->id }}" class="btn btn-sm btn-neutral">Kembali</a>
        </div>
        <div>

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full max-w-2xl">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Kode Role</x-table.header.column>
                    <x-table.header.column class="border-x">Role</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->koderole }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->role }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <div class="join">
                                <form action="/role-user/{{ $item->id }}/{{ $user->id }}" method="post">
                                    @csrf
                                    <button class="btn btn-xs btn-outline btn-neutral"
                                        onclick="return confirm('Apakah Anda yakin akan menambah role ini ini?');">Pilih</button>
                                </form>
                            </div>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
