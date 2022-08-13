@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tarik Data detail Akun</h1>
    </div>
    <div class="row">
        <div class="col">
            {{-- <?php if ($this->session->flashdata('pesan')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Selamat!</strong> <?= $this->session->flashdata('pesan'); ?>
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?> --}}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/tagihan/realisasi/{{ $data->id }}/index" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off"> 
            <div class="input-group">
                <input type="text" name="kode" class="form-control" placeholder="detail akun">
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
                                <td class="text-right">Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">Rp{{ number_format($item->anggaran-$item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
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
            
        </div>
    </div>

</main>
@endsection