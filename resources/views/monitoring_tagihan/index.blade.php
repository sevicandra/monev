@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Monitoring Tagihan</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="notagihan" class="form-control" placeholder="nomor SPP/SPBy">
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
                            <th>Tgl SPM</th>
                            <th>No SP2D</th>
                            <th>Tgl SP2D</th>
                            <th>Jenis Tagihan</th>
                            <th>Unit</th>
                            <th>PPK</th>
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
                            <td>
                                @if (isset($item->spm))
                                    {{ $item->spm->tanggal_spm }}
                                @endif
                            </td>
                            <td>
                                @if (isset($item->spm))
                                {{ $item->spm->nomor_sp2d }}
                            @endif
                            </td>
                            <td>
                                @if (isset($item->spm))
                                    {{ $item->spm->tanggal_sp2d }}
                                @endif
                            </td>
                            <td>{{ $item->jnstagihan }}</td>
                            <td>{{ $item->unit->namaunit }}</td>
                            <td></td>
                            <td>{{ $item->dokumen->namadokumen }}</td>
                            <td class="text-right">Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                            <td class="pb-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/monitoring-tagihan/{{ $item->id }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Dokumen</a>
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
    <div class="row">
        <div class="col-lg-6">
            
        </div>
    </div>

</main>
@endsection