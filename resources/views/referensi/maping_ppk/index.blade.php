@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">PPK</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/referensi" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Sebelumnya</a>
                <a href="referensi" class="btn btn-sm btn-outline-secondary mt-1 mb-1"> Kembali</a>
            </div>
            <div class="col-lg-5">
                <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
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
                                <th>NIP</th>
                                <th>Satker</th>
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
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->satker }}</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/maping-ppk/{{ $item->id }}/pagu" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Maping Pagu</a>
                                        <a href="/maping-ppk/{{ $item->id }}/staf" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Maping Staf</a>
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