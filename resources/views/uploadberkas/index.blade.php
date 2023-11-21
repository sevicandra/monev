@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">File Upload</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="{{ $back }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="{{ $upload }}" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Berkas</th>
                    <th class="border border-base-content">Keterangan</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">File</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data->berkasupload as $item)
                    <tr>
                        <td class="text-center border border-base-content">{{ $i }}</td>
                        <td class="border border-base-content">{{ optional($item->berkas)->namaberkas }}</td>
                        <td class="border border-base-content">{{ $item->uraian }}</td>
                        <td class="border border-base-content">{{ $item->created_at }}</td>
                        <td class="text-center border border-base-content">
                            <div class="join">
                                <a href="/file-view/{{ $item->file }}" class="btn btn-xs btn-outline btn-neutral"
                                    target="_blank">Preview File</a>
                            </div>
                        </td>
                        <td class="text-center border border-base-content">
                            <div class="join">
                                <form action="{{ $delete }}{{ $item->id }}/delete" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-error"
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
