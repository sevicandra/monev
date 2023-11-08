@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi Per PPK</h1>
    </div>
    <div class="flex px-4 gap-2">
        <a href="/dashboard/ppk"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
            Tagihan</a>
        <a href="/dashboard/ppk?sp2d=ya"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
            SP2D</a>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse min-w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Pagu</th>
                    <th class="border border-base-content">Realisasi</th>
                    <th class="border border-base-content">Pengembalian</th>
                    <th class="border border-base-content">Sisa Pagu</th>
                    <th class="border border-base-content">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pagu = 0;
                    $realisasi = 0;
                    $pengembalian = 0;
                    $i = 1;
                @endphp
                @foreach ($ppk as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content ">
                            <a class="link link-base-content" href="ppk/{{ $item->id }}">{{ $item->nama }}</a>
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->paguppk->sum('anggaran'), 2, ',', '.') }}
                            @php
                                $pagu += $item->paguppk->sum('anggaran');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->realisasippk()->sum('realisasi'), 2, ',', '.') }}
                            @php
                                $realisasi += $item->realisasippk()->sum('realisasi');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->sspbppk()->sum('nominal_sspb'), 2, ',', '.') }}
                            @php
                                $pengembalian += $item->sspbppk()->sum('nominal_sspb');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->paguppk->sum('anggaran') - $item->realisasippk()->sum('realisasi') + $item->sspbppk()->sum('nominal_sspb'), 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-center">
                            @if ($item->paguppk->sum('anggaran') != 0)
                                {{ number_format((($item->realisasippk()->sum('realisasi') - $item->sspbppk()->sum('nominal_sspb')) * 100) / $item->paguppk->sum('anggaran'), 2, ',', '.') }}%
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
                    <th class="border border-base-content text-center" colspan="2">Jumlah</th>
                    <th class="border border-base-content text-end"> {{ number_format($pagu, 2, ',', '.') }} </th>
                    <th class="border border-base-content text-end"> {{ number_format($realisasi, 2, ',', '.') }} </th>
                    <th class="border border-base-content text-end"> {{ number_format($pengembalian, 2, ',', '.') }} </th>
                    <th class="border border-base-content text-end">{{ number_format($pagu + $realisasi - $pengembalian, 2, ',', '.') }}</th>
                    <th class="border border-base-content text-center">
                        @if ($pagu != 0)
                            {{ number_format((($realisasi - $pengembalian) * 100) / $pagu, 2, ',', '.') }}%
                        @else
                            0%
                        @endif
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
