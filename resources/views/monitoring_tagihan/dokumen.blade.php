@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Arsip Dokumen</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/monitoring-tagihan" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-dokumen :aksi="FALSE">
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
                </tr>
            @endforeach
        </x-dokumen>
    </div>
@endsection
