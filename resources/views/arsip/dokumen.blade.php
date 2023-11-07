@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Arsip Dokumen</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/arsip" class="btn btn-sm btn-neutral">Sebelumnya</a>
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
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data->berkasupload as $item)
                    <tr>
                        <td class="text-center border border-base-content">{{ $i }}</td>
                        <td class="border border-base-content">{{ $item->berkas->namaberkas }}</td>
                        <td class="border border-base-content">{{ $item->uraian }}</td>
                        <td class="border border-base-content">{{ $item->created_at }}</td>
                        <td class="text-center border border-base-content">
                            <div class="join">
                                <a href="/file-view/{{ $item->file }}" class="btn btn-xs btn-outline btn-neutral"
                                    target="_blank">Preview File</a>
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
