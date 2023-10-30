@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Payroll</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/payroll" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
                <a href="/payroll/{{ $tagihan->id }}/cetak" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2" target="_blank">Cetak</a>
            </div>
            <div class="col-lg-5">
                <form action="" method="get" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nama Penerima">
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
                                <th>Nama</th>
                                <th>Nomor Rekening</th>
                                <th>Nama Bank</th>
                                <th>Bruto</th>
                                <th>Pajak</th>
                                <th>Adm.</th>
                                <th>Netto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->norek }}</td>
                                <td>{{ $item->bank }}</td>
                                <td class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item->pajak, 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item->admin, 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item->netto, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {{$data->links()}}
            </div>
        </div>

    </main>
@endsection