@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tarik Data detail Akun</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-5">
            <a href="/tagihan/{{ $data->id }}/realisasi" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-7">
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="program" class="form-control" value="{{request('program')}}" placeholder="Program" >
                    <input type="text" name="kegiatan" class="form-control" value="{{request('kegiatan')}}" placeholder="Kegiatan">
                    <input type="text" name="kro" class="form-control" value="{{request('kro')}}" placeholder="KRO">
                    <input type="text" name="ro" class="form-control" value="{{request('ro')}}" placeholder="RO">
                    <input type="text" name="komponen" class="form-control" value="{{request('komponen')}}" placeholder="Komponen">
                    <input type="text" name="subkomponen" class="form-control" value="{{request('subkomponen')}}" placeholder="Subkomponen">
                    <input type="text" name="akun" class="form-control" value="{{request('akun')}}" placeholder="Akun">
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
                            <th>Pagu</th>
                            <th>Realisasi</th>
                            <th>Sisa Anggaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagu as $item)
                            <tr>
                                <td class="text-center"></td>
                                <td>{{ $item->program }}</td>
                                <td>{{ $item->kegiatan }}</td>
                                <td>{{ $item->kro }}</td>
                                <td>{{ $item->ro }}</td>
                                <td>{{ $item->komponen }}</td>
                                <td>{{ $item->subkomponen }}</td>
                                <td>{{ $item->akun }}</td>
                                <td class="text-right">Rp{{ number_format($item->anggaran, 2, ',', '.') }}</td>
                                <td class="text-right">Rp{{ number_format($item->realisasi->sum('realisasi')-$item->sspb->sum('nominal_sspb'), 2, ',', '.') }}</td>
                                <td class="text-right">Rp{{ number_format($item->anggaran-$item->realisasi->sum('realisasi')+$item->sspb->sum('nominal_sspb'), 2, ',', '.') }}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form action="/tagihan/{{ $data->id }}/realisasi/{{ $item->id }}" method="post">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-secondary pt-0 pb-0">Pilih</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{$pagu->links()}}
        </div>
    </div>

</main>
@endsection