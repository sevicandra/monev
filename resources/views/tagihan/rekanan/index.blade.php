@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Rekanan</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/tagihan" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
                <a href="/tagihan/{{ $tagihan->id }}/rekanan/create" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Tambah</a>
            </div>
            <div class="col-lg-5">
                <form action="" method="get" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search" value="{{request('search')}}">
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
                                <th>NPWP</th>
                                <th>Id Pajak</th>
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
                                <td>{{ $item->nama }}</td>
                                <td>
                                    @switch($item->npwp)
                                        @case(1)
                                            YA
                                            @break
                                        @case(0)
                                            TIDAK
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $item->idpajak }}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form action="/tagihan/{{ $tagihan->id }}/rekanan/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                        </form>
                                        <a href="/tagihan/{{ $tagihan->id }}/rekanan/{{ $item->id }}/ppn" class="btn btn-sm btn-outline-secondary pt-0 pb-0">PPN</a>
                                        <a href="/tagihan/{{ $tagihan->id }}/rekanan/{{ $item->id }}/pph" class="btn btn-sm btn-outline-secondary pt-0 pb-0">PPh</a>
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