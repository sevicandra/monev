@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Dokumen</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/dokumen/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div>

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Kode Dokumen</th>
                    <th class="border border-base-content">Nama Dokumen</th>
                    {{-- <th class="border border-base-content">Status DNP</th>
                    <th class="border border-base-content">Status PPh</th> --}}
                    <th class="border border-base-content">Status Rekanan</th>
                    <th class="border border-base-content">Status DNP Perjadin</th>
                    <th class="border border-base-content">Status DNP HONOR</th>
                    <th class="border border-base-content">BLBI</th>
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
                        <td class="border border-base-content">{{ $item->kodedokumen }}</td>
                        <td class="border border-base-content">{{ $item->namadokumen }}</td>
                        {{-- <td class="border border-base-content text-center">{{ $item->statusdnp }}</td>
                        <td class="border border-base-content text-center">{{ $item->statuspph }}</td> --}}
                        <td class="border border-base-content text-center">{{ $item->statusrekanan }}</td>
                        <td class="border border-base-content text-center">{{ $item->dnp_perjadin }}</td>
                        <td class="border border-base-content text-center">{{ $item->dnp_honor }}</td>
                        <td class="border border-base-content text-center">{{ $item->blbi }}</td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <a href="/dokumen/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Ubah</a>
                                <form action="/dokumen/{{ $item->id }}" method="post">
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
