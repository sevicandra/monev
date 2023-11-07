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
            <a href="/bendahara" class="btn btn-neutral btn-sm">Sebelumnya</a>
            <a href="/bendahara/{{ $tagihan->id }}/rekanan/create" class="btn btn-neutral btn-sm">Tambah</a>
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
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">NPWP</th>
                    <th class="border border-base-content">No. NIK/NPWP</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content">{{ $item->nama }}</td>
                        <td class="border border-base-content text-center">
                            @switch($item->npwp)
                                @case(1)
                                    YA
                                @break

                                @case(0)
                                    TIDAK
                                @break
                            @endswitch
                        </td>
                        <td class="border border-base-content text-center">{{ $item->idpajak }}</td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $item->id }}/ppn"
                                    class="btn btn-xs btn-outline btn-neutral join-item">PPN</a>
                                <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $item->id }}/pph"
                                    class="btn btn-xs btn-outline btn-neutral join-item">PPh</a>
                                <form action="/bendahara/{{ $tagihan->id }}/rekanan/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-error join-item"
                                        onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
