@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Satuan Kerja</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/satker/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
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
                    <th class="border border-base-content">Kode Satker</th>
                    <th class="border border-base-content">Nama Satker</th>
                    <th class="border border-base-content">Unit Eselon II</th>
                    <th class="border border-base-content">Unit Eselon III</th>
                    <th class="border border-base-content">Nama Gedung</th>
                    <th class="border border-base-content">Alamat Kantor</th>
                    <th class="border border-base-content">Alamat Email & No. Tlp</th>
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
                        <td class="border border-base-content">{{ $item->kodesatker }}</td>
                        <td class="border border-base-content">{{ $item->namasatker }}</td>
                        <td class="border border-base-content"></td>
                        <td class="border border-base-content"></td>
                        <td class="border border-base-content"></td>
                        <td class="border border-base-content"></td>
                        <td class="border border-base-content"></td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <a href="/satker/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Ubah</a>
                                <form action="/satker/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-neutral join-item"
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
