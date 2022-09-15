@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Riwayat</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-5">
            <a href="/monitoring-tagihan" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
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
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Action</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data->log as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ indonesiaDate($item->created_at) }}</td>
                                <td>{{ $item->User }}</td>
                                <td>{{ $item->action }}</td>
                                <td class="text-center">{{ $item->catatan }}</td>
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