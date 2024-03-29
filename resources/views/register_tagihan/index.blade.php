@extends('layout.main')
@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Register Tagihan</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <form action="/register" method="post">
                @csrf
                <button class="btn btn-sm btn-outline-secondary mt-1 mb-1" onclick="return confirm('Apakah Anda yakin akan menambah data?');"> Tambah Data</button>
            </form>
        </div>
        <div class="col-lg-5">
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Nomor" value="{{request('search')}}">
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
                            <th>Nomor Register</th>
                            <th>Tanggal</th>
                            <th>Jumlah Tagihan</th>
                            <th>Total Nilai</th>
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
                            <td>{{ $item->nomor }}</td>
                            <td>{{ indonesiaDate($item->created_at) }} </td>
                            <td class="text-center">
                                @if ($item->tagihan)
                                    @php
                                        $jumlah = $item->tagihan->count()
                                    @endphp
                                @else
                                    @php
                                        $jumlah =0
                                    @endphp
                                @endif
                                {{ $jumlah }}
                            </td>
                            <td class="text-right">
                                @php
                                    $total=0
                                @endphp
                                @foreach ($item->tagihan as $tagihan)
                                    @php
                                        $total=$total+$tagihan->realisasi->sum('realisasi')
                                    @endphp
                                @endforeach
                                Rp{{ number_format($total, 2, ',', '.') }}
                            </td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <form action="/register/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-secondary pt-0 pb-0" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                    </form>
                                    <a href="/register/{{ $item->id }}" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    <a href="/register/{{ $item->id }}/preview" class="btn btn-sm btn-outline-secondary pt-0 pb-0" target="_blank">Preview</a>
                                    @can('PPK', auth()->user()->role)
                                    <a href="/register/{{ $item->id }}/esign" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Kirim</a>
                                    @endcan
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
            {{$data->links()}}
        </div>
    </div>

</main>
@endsection