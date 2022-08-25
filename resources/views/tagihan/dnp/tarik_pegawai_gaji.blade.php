@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tarik Data Pegawai Dari Gaji</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/tagihan/{{ $tagihan->id }}/dnp" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="get" autocomplete="off">
            <div class="input-group">
                <input type="text" name="nama" class="form-control" placeholder="nama pegawai">
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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Kdgol</th>
                            <th>Rekening</th>
                            <th>Nama Bank</th>
                            <th>Nama Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{  $item->nip  }}</td>
                                <td>{{  $item->nmpeg  }}</td>
                                <td>{{  $item->kdgol  }}</td>
                                <td>{{  $item->rekening  }}</td>
                                <td>{{  $item->nm_bank  }}</td>
                                <td>{{  $item->nmrek  }}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form action="/tagihan/{{ $tagihan->id }}/dnp/{{ $item->nip }}" method="post">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-secondary pt-0 pb-0">Pilih</button>
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
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            
        </div>
    </div>

</main>
@endsection