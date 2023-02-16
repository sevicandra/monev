@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-5">
            <a href="/arsip" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-3">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Berkas</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data->berkasupload as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $item->berkas->namaberkas }}</td>
                                <td>{{ $item->uraian }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/file-view/{{ $item->file }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Preview File</a>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++
                            @endphp
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
@endsection