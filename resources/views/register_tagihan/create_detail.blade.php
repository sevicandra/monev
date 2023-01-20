@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Detail</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/register/{{ $register->id }}" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-5">
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
                            <th>Uraian</th>
                            <th>Jenis Tagihan</th>
                            <th>Unit</th>
                            <th>Jenis Dokumen</th>
                            <th>Bruto</th>
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
                            <td>{{ $item->notagihan }}</td>
                            <td>{{ $item->tgltagihan }}</td>
                            <td>{{ $item->uraian }}</td>
                            <td>
                                @switch($item->jnstagihan)
                                    @case('0')
                                        SPBy
                                        @break
                                    @case('1')
                                        SPP
                                        @break
                                    @case('2')
                                        KKP
                                        @break
                                @endswitch    
                            </td>
                            <td>{{ $item->unit->namaunit }}</td>
                            <td>{{ $item->dokumen->namadokumen }}</td>
                            <td class="text-right">Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                            <td class="pb-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <form action="/register/{{ $register->id }}/tagihan/{{ $item->id }}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-secondary pt-0 pb-0">Pilih</button>
                                    </form>
                                </div>
                                <a class="btn btn-sm btn-outline-secondary pt-0 pb-0" href="/register/{{ $register->id }}/tagihan/{{ $item->id }}/tolak">Tolak</a>
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