@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Rekanan</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/verifikasi/{{ $tagihan->id }}/rekanan" class="btn btn-neutral btn-sm">Sebelumnya</a>
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
                    <td class="border text-center">{{ $loop->iteration }}</td>
                    <td class="border text-center">{{ $item->nama }}</td>
                    <td class="border text-center">
                        @switch($item->npwp)
                            @case(1)
                                YA
                            @break

                            @default
                                TIDAK
                        @endswitch
                    </td>
                    <td class="border text-center">{{ $item->idpajak }}</td>
                    <td class="border text-center">
                        <form action="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $item->id }}" method="post">
                            @csrf
                            <button class="btn btn-xs btn-outline btn-neutral">Pilih</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-rekanan>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
