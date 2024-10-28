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
            <a href="/verifikasi" class="btn btn-neutral btn-sm">Sebelumnya</a>
            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/create" class="btn btn-neutral btn-sm">Tambah</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Search" value="{{ request('search') }}">
                    <button class="btn join-item btn-neutral btn-sm" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-rekanan>
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
                            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $item->id }}/ppn"
                                class="btn btn-xs btn-outline btn-neutral join-item">PPN</a>
                            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $item->id }}/pph"
                                class="btn btn-xs btn-outline btn-neutral join-item">PPh</a>
                            <form action="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $item->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-rekanan>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
