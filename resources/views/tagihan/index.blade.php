@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tagihan</h1>
    </div>
    <div class="row">
        <div class="col">
        @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/tagihan/create" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Tambah Data</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="notagihan" class="form-control" placeholder="Nomor Tagihan">
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
                                <td>{{ $item->jnstagihan }}</td>
                                <td>{{ $item->unit->namaunit }}</td>
                                <td>{{ $item->dokumen->namadokumen }}</td>
                                <td class="text-right">Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/tagihan/{{ $item->id }}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                        <form action="/tagihan/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                        </form>
                                        <a href="/tagihan/{{ $item->id }}/realisasi" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Realisasi</a>
                                        @if ($item->dokumen->statusdnp === '1')
                                        <a href="/tagihan/{{ $item->id }}/dnp" class="btn btn-sm btn-outline-secondary pt-0 pb-0">DNP</a>
                                        @endif
                                        @if ($item->dokumen->statusrekanan === '1')
                                        <a href="/tagihan/{{ $item->id }}/rekanan" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Rekanan</a>
                                        @endif
                                        <a href="/tagihan/{{ $item->id }}/upload" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Upload</a>
                                        <form action="/tagihan/{{ $item->id }}/kirim" method="post">
                                            @csrf
                                            <button href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Kirim</button>
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