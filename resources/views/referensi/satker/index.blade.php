@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Satuan Kerja</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/referensi" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Sebelumnya</a>
            <a href="/satker/create" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Tambah Data</a>
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
                            <th>Kode Satker</th>
                            <th>Nama Satker</th>
                            <th>Unit Eselon II</th>
                            <th>Unit Eselon III</th>
                            <th>Nama Gedung</th>
                            <th>Alamat Kantor</th>
                            <th>Alamat Email & No. Tlp</th>
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
                            <td>{{ $item->kodesatker }}</td>
                            <td>{{ $item->namasatker }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/satker/{{ $item->id }}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Ubah</a>
                                    <form action="/satker/{{ $item->id }}" method="post">
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
            {{ $data->links() }}
        </div>
    </div>

</main>   
@endsection