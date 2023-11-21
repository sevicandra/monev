@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Arsip</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
        </div>
        <div class="col-lg-5">
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Nomor Register">
                    <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Nomor</th>
                            <th>Tanggal</th>
                            <th>PPK</th>
                            <th>Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $item->nomor }}{{ $item->ekstensi }}{{ $item->tahun }}</td>
                                <td>{{ $item->dokumen_date }}</td>
                                <td>{{ optional($item->ppk)->nama }}</td>
                                <td>
                                    <a href="{{ config('app.url').'/file-view/'.$item->file }}" class="btn btn-sm btn-outline-success pt-0 pb-0" target="_blank">Dokumen</a>
                                </td>
                            </tr>
                        @php
                            $i++;
                        @endphp       
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{-- {{$data->links()}} --}}
        </div>
    </div>

</main>
@endsection