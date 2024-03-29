@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/register" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
            <a href="/register/{{ $register->id }}/create" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Tambah Data</a>
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
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @php
                            $i++
                        @endphp
                        @endforeach
                        <tr>
                            <th colspan="7" class="text-center">Jumlah</th>
                            <th class="text-right">
                            @php
                                $jumlah=0
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    $jumlah=$jumlah+$item->realisasi->sum('realisasi')
                                @endphp
                            @endforeach
                            Rp{{ number_format($jumlah, 2, ',', '.') }}
                            </th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
@endsection