@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Referensi Rekening</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/referensi-rekening/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Search" value="{{ request('search') }}">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">NIP/NIK/NPWP</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">Nomor Rekening</th>
                    <th class="border border-base-content">Nama Bank</th>
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
                        <td class="border border-base-content">{{ $item->kode }}</td>
                        <td class="border border-base-content">{{ $item->nama }}</td>
                        <td class="border border-base-content">{{ $item->norek }}</td>
                        <td class="border border-base-content">
                            @if ($item->bank === 'Other')
                                {{ $item->otherbank }}
                            @else
                                {{ $item->bank }}
                            @endif
                        </td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <a href="/referensi-rekening/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Ubah</a>
                                <form action="/referensi-rekening/{{ $item->id }}" method="post">
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
    <div class="row">
        <div class="col-lg-6">
            {{ $data->links() }}
        </div>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
