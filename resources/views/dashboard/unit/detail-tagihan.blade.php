@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Realisasi {{ $bulan->namabulan }}</h1>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                @if ($bulan->kodebulan)
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}/tagihan" class="btn btn-sm btn-outline-primary mt-1 @if (request('sp2d') === 'ya') @else active @endif">Per Tagihan</a>
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}/tagihan?sp2d=ya" class="btn btn-sm btn-outline-primary mt-1 ml-2 @if (request('sp2d') === 'ya') active @else @endif">Per SP2D</a>
                @else
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}/tagihan?sp2d=ya" class="btn btn-sm btn-outline-primary mt-1 ml-2 @if (request('sp2d') === 'ya') active @else @endif">Per SP2D</a>
                @endif
            </div>
            <div class="col-lg-5">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-10">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th>Nomor</th>
                                <th>Jenis Tagihan</th>
                                <th>Nomor Tagihan</th>
                                <th>Tanggal Tagihan</th>
                                <th>POK</th>
                                <th>Realisasi</th>
                                <th>SSPB</th>
                                <th>Tanggal SP2D</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td class="text-center">{{$i}}</td>
                                    <td class="text-center">
                                        @switch($item->jnstagihan)
                                            @case('0')
                                                SPBy
                                                @break
                                            @case('1')
                                                SPP
                                                @break
                                            @case('2')
                                                KKP
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-center">{{$item->notagihan}}</td>
                                    <td class="text-center">{{$item->tgltagihan}}</td>
                                    <td>
                                        {{ $item->pok }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->realisasi, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->nominal_sspb, 2, ',', '.') }}
                                    </td>
                                    <td>{{ $item->tanggal_sp2d }}</td>
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