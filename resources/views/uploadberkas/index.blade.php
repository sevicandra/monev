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
        <x-dokumen>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->berkas)->namaberkas }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ explode('.', $item->file)[1] }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->uraian }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->created_at }}</x-table.body.column>
                    <x-table.body.column class="text-center border">
                        <div class="join">
                            <a href="/file-view/{{ $item->file }}" class="btn btn-xs btn-outline btn-neutral"
                                target="_blank">Preview File</a>
                        </div>
                    </x-table.body.column>
                    <x-table.body.column class="text-center border">
                        <div class="join">
                            <form action="{{ $delete }}{{ $item->id }}/delete" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline btn-error"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-dokumen>
    </div>
@endsection
