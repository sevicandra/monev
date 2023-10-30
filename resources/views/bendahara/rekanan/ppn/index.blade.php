@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">PPN {{ $rekanan->nama }}</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/bendahara/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
                <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/create" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Tambah</a>
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
                                <th>Nomor Faktur</th>
                                <th>Tanggal Faktur</th>
                                <th>Tarif</th>
                                <th>PPN</th>
                                <th>NOP</th>
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
                                <td>{{ $item->nomorfaktur }}</td>
                                <td>{{ indonesiaDate($item->tanggalfaktur)}}</td>
                                <td>{{ $item->tarif*100}}%</td>
                                <td>{{ number_format(floor($item->ppn*$item->tarif), 2, ',', '.')}}</td>
                                <td>{{ number_format($item->ppn, 2, ',', '.')}}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form action="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                        </form>
                                        <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/{{ $item->id }}/edit" class="btn btn-sm btn-outline-secondary pt-0 pb-0">edit</a>
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