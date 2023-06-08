@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Realisasi Unit {{ $unit->namaunit }}</h1>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/dashboard/unit/{{ $unit->id }}" class="btn btn-sm btn-outline-primary mt-1 @if (request('sp2d') === 'ya') @else active @endif">Per Tagihan</a>
                <a href="/dashboard/unit/{{ $unit->id }}?sp2d=ya" class="btn btn-sm btn-outline-primary mt-1 ml-2 @if (request('sp2d') === 'ya') active @else @endif">Per SP2D</a>
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
                                <th>Bulan</th>
                                <th>Realisasi</th>
                                <th>SSPB</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <a target="_blank" href="/dashboard/unit/{{ $unit->id }}/{{ $item->bulan }}?sp2d={{ request('sp2d') }}">
                                            {{ $item->namabulan }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->bulan)
                                        <a href="/dashboard/unit/{{ $unit->id }}/{{ $item->bulan }}/tagihan/?sp2d={{ request('sp2d') }}" target="_blank">
                                            Rp {{ number_format($item->total_realisasi, 2, ",", ".") }}
                                        </a>    
                                        @else
                                        <a href="/dashboard/unit/{{ $unit->id }}/null/tagihan/?sp2d={{ request('sp2d') }}" target="_blank">
                                            Rp {{ number_format($item->total_realisasi, 2, ",", ".") }}
                                        </a>  
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->total_sspb, 2, ",", ".") }}</td>
                                    <td>Rp {{ number_format($item->total_realisasi-$item->total_sspb, 2, ",", ".") }}</td>
                                </tr>
                            @endforeach
                                <tr>
                                    <td>Total</td>
                                    <td>Rp {{ number_format($data->sum('total_realisasi'), 2, ",", ".") }}</td>
                                    <td>Rp {{ number_format($data->sum('total_sspb'), 2, ",", ".") }}</td>
                                    <td></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection