@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">COA</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/monitoring-tagihan" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="kro" class="form-control" placeholder="KRO">
                    <input type="text" name="ro" class="form-control" placeholder="RO">
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
                            <th>Program</th>
                            <th>Kegiatan</th>
                            <th>KRO</th>
                            <th>RO</th>
                            <th>Komponen</th>
                            <th>Subkomponen</th>
                            <th>Akun</th>
                            <th>Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data->realisasi as $item)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $item->pagu->program }}</td>
                            <td>{{ $item->pagu->kegiatan }}</td>
                            <td>{{ $item->pagu->kro }}</td>
                            <td>{{ $item->pagu->ro }}</td>
                            <td>{{ $item->pagu->komponen }}</td>
                            <td>{{ $item->pagu->subkomponen }}</td>
                            <td>{{ $item->pagu->akun }}</td>
                            <td class="text-right">{{ number_format($item->realisasi, 2, ',', '.') }}</td>
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