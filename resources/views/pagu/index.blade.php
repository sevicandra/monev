@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pagu</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/pagu/create" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Tambah Data</a>
            <a href="/pagu/import" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2"> Impor Data</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="post" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="kro" class="form-control" placeholder="KRO">
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
                            <th>Anggaran</th>
                            <th>Unit</th>
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
                            <td class="text-center">{{ $item->program }}</td>
                            <td class="text-center">{{ $item->kegiatan }}</td>
                            <td class="text-center">{{ $item->kro }}</td>
                            <td class="text-center">{{ $item->ro }}</td>
                            <td class="text-center">{{ $item->komponen }}</td>
                            <td class="text-center">{{ $item->subkomponen }}</td>
                            <td class="text-center">{{ $item->akun }}</td>
                            <td class="text-right">Rp{{ number_format($item->anggaran, 2, ',', '.') }}</td>
                            <td class="text-center"> @if ($item->unit) {{ $item->unit->namaunit }} @endif </td>
                            <td  class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/pagu/{{ $item->id }}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                    
                                    <form action="/pagu/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
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