@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">DNP Honorarium</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/tagihan-blbi" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
                <a href="/tagihan-blbi/{{ $tagihan->id }}/dnp/cetak" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2" target="_blank">Cetak</a>
            </div>
            <div class="col-lg-5">
                <form action="" method="get" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nama Pegawai" value="{{request('search')}}">
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
                                <th>Golongan</th>
                                <th>Jabatan</th>
                                <th>Netto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kodegolongan }}</td>
                                @if ($item->nominal) 
                                    <td class="text-right">{{ number_format($item->nominal->bruto, 2, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($item->nominal->pph, 2, ',', '.') }}</td>
                                    <td class="text-right">{{ number_format($item->nominal->netto, 2, ',', '.') }}</td>
                                @else 
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                @endif
                                <td>{{ $item->rekening }}</td>
                                <td>{{ $item->namabank }}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($item->nominal)
                                            <a href="/tagihan-blbi/{{ $tagihan->id }}/dnp/{{ $item->id }}/nominal/{{ $item->nominal->id }}/update/" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Nominal</a>
                                        @else
                                            <a href="/tagihan-blbi/{{ $tagihan->id }}/dnp/{{ $item->id }}/nominal/" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Nominal</a>
                                        @endif
                                        <form action="/tagihan-blbi/{{ $tagihan->id }}/dnp/{{ $item->id }}" method="post">
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
                {{$data->links()}}
            </div>
        </div>

    </main>
@endsection