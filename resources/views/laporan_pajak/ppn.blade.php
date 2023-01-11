@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> Rekap PPN </h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/laporan-pajak/pph" class="btn btn-sm btn-outline-primary mt-1">PPh</a>
            <a href="/laporan-pajak/ppn" class="btn btn-sm btn-outline-primary mt-1 ml-2">PPN</a>
        </div>
        <div class="col-lg-5">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            @for ($i = 1; $i < 13; $i++)
            <a href="/laporan-pajak/ppn?bulan={{$i}}" class="btn btn-sm btn-outline-primary mt-1">{{$i}}</a>
            @endfor
        </div>
        <div class="col-lg-5 d-flex flex-row-reverse ">
            @if (request('bulan'))
            <a href="/laporan-pajak/ppn/cetak?bulan={{request('bulan')}}" class="btn btn-sm btn-outline-success mt-1 ">cetak</a>
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>SPM</th>
                            <th>SPBy</th>
                            <th>NTPN/SP2D</th>
                            <th>Tanggal NTPN/SP2D</th>
                            <th>No. NPWP</th>
                            <th>Rekanan</th>
                            <th>Nomor Faktur Pajak</th>
                            <th>Tanggal Faktur Pajak</th>
                            <th>Tarif</th>
                            <th>PPh</th>
                            <th>NOP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$i}}</td>
                                <td>@if ($item->tagihan->jnstagihan === '1') {{$item->tagihan->notagihan}} @endif</td>
                                <td>@if ($item->tagihan->jnstagihan === '0') {{$item->tagihan->notagihan}} @endif</td>
                                @if ($item->tagihan->jnstagihan === '1')
                                <td>
                                    @if ($item->tagihan->spm)
                                        {{$item->tagihan->spm->nomor_sp2d}}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->tagihan->spm)
                                    {{$item->tagihan->spm->tanggal_sp2d}}
                                    @endif
                                </td>
                                @else
                                <td> {{$item->ntpn}} </td>
                                <td>{{$item->tanggalntpn}}</td>
                                @endif
                                <td>{{$item->rekanan->idpajak}}</td>
                                <td>{{$item->rekanan->nama}}</td>
                                <td>{{$item->nomorfaktur}}</td>
                                <td>{{$item->tanggalfaktur}}</td>
                                <td>{{ $item->tarif*100}}%</td>
                                <td>{{ number_format(floor($item->ppn*($item->tarif)), 2, ',', '.')}}</td>
                                <td>{{ number_format($item->ppn, 2, ',', '.')}}</td>
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
</main>
@endsection