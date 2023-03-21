@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Realisasi Per Unit</h1>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/dashboard/ppk" class="btn btn-sm btn-outline-primary mt-1 @if (request('sp2d') === 'ya') @else active @endif">Per Tagihan</a>
                <a href="/dashboard/ppk?sp2d=ya" class="btn btn-sm btn-outline-primary mt-1 ml-2 @if (request('sp2d') === 'ya') active @else @endif">Per SP2D</a>
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
                                <th>PPK</th>
                                <th>Pagu</th>
                                <th>Realisasi</th>
                                <th>Pengembalian</th>
                                <th>Sisa Pagu</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pagu=0;
                                $realisasi=0;
                                $pengembalian=0;
                                $i=1;
                            @endphp
                            @foreach ($ppk as $item)
                                <tr>
                                    <td class="text-center">{{$i}}</td>
                                    <td>
                                        <a href="ppk/{{ $item->id }}">{{ $item->nama }}</a>
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->paguppk->sum('anggaran'), 2, ',', '.') }}
                                        @php
                                            $pagu += $item->paguppk->sum('anggaran');
                                        @endphp
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->realisasippk()->sum('realisasi'), 2, ',', '.') }}
                                        @php
                                            $realisasi += $item->realisasippk()->sum('realisasi');
                                        @endphp
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->sspbppk()->sum('nominal_sspb'), 2, ',', '.') }}
                                        @php
                                            $pengembalian += $item->sspbppk()->sum('nominal_sspb');
                                        @endphp
                                    </td>
                                    <td class="text-right">{{ number_format($item->paguppk->sum('anggaran')-$item->realisasippk()->sum('realisasi')+$item->sspbppk()->sum('nominal_sspb'), 2, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($item->paguppk->sum('anggaran') != 0)
                                            {{ number_format(($item->realisasippk()->sum('realisasi')-$item->sspbppk()->sum('nominal_sspb'))*100/$item->paguppk->sum('anggaran'), 2, ',', '.') }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            <tr>
                                <th class="text-center" colspan="2">Jumlah</th>
                                <th class="text-right"> {{ number_format($pagu, 2, ',', '.') }} </th>
                                <th class="text-right"> {{ number_format($realisasi, 2, ',', '.') }} </th>
                                <th class="text-right"> {{ number_format($pengembalian, 2, ',', '.') }} </th>
                                <th class="text-right">{{ number_format($pagu+$realisasi-$pengembalian, 2, ',', '.') }}</th>
                                <th class="text-center">
                                    @if ($pagu != 0)
                                    {{ number_format(($realisasi-$pengembalian)*100/$pagu, 2, ',', '.') }}%
                                    @else
                                    0%
                                    @endif
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection