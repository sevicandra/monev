@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Realisasi Bulan {{ $bulan->namabulan }}</h1>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}" class="btn btn-sm btn-outline-primary mt-1 @if (request('sp2d') === 'ya') @else active @endif">Per Tagihan</a>
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}?sp2d=ya" class="btn btn-sm btn-outline-primary mt-1 ml-2 @if (request('sp2d') === 'ya') active @else @endif">Per SP2D</a>
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
                                <th>POK</th>
                                <th>Pagu</th>
                                <th>Realisasi</th>
                                <th>Pengembalian</th>
                                <th>Sisa Pagu</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td class="text-center">{{$i}}</td>
                                    <td>
                                        {{ $item->pok }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->anggaran, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->realisasi, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->total_sspb, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">{{ number_format($item->anggaran-$item->realisasi+$item->total_sspb, 2, ',', '.') }}</td>
                                    <td class="text-center">{{ number_format(($item->realisasi-$item->total_sspb)*100/$item->anggaran, 2, ',', '.') }}%</td>
                                </tr>
                                @php
                                $i++;
                                @endphp
                            @endforeach
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="text-right">{{ number_format($data->sum('anggaran'), 2, ',', '.') }}</th>
                                <th class="text-right">{{ number_format($data->sum('realisasi'), 2, ',', '.') }}</th>
                                <th class="text-right">{{ number_format($data->sum('total_sspb'), 2, ',', '.') }}</th>
                                <th class="text-right">{{ number_format($data->sum('anggaran')-$data->sum('realisasi')+$data->sum('total_sspb'), 2, ',', '.') }}</th>
                                <th class="text-center">{{ number_format(($data->sum('realisasi')-$data->sum('total_sspb'))*100/$data->sum('anggaran'), 2, ',', '.') }}%</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection