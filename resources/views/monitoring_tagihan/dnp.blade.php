@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">DNP</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/monitoring-tagihan" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
            </div>
            <div class="col-lg-5">
                <form action="" method="post" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Pegawai">
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
                                <th>Bruto</th>
                                <th>PPh</th>
                                <th>Netto</th>
                                <th>Rekening</th>
                                <th>Nama Bank</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kodegolongan }}</td>
                                <td class="text-right">{{  number_format(optional($item->nominal)->bruto, 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(optional($item->nominal)->pph, 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(optional($item->nominal)->netto, 2, ',', '.') }}</td>
                                <td>{{ $item->rekening }}</td>
                                <td>{{ $item->namabank }}</td>
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
                {{$data->links()}}
            </div>
        </div>

    </main>
@endsection