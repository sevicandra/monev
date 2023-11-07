@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi Per Unit</h1>
    </div>
    <div class="flex px-4 gap-2">
        <a href="/dashboard/unit"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
            Tagihan</a>
        <a href="/dashboard/unit?sp2d=ya"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
            SP2D</a>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse min-w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Unit</th>
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
                @foreach ($unit as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content">
                            <a class="link link-neutral" href="unit/{{ $item->id }}">{{ $item->namaunit }}</a>
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->pagu->sum('anggaran'), 2, ',', '.') }}
                            @php
                                $pagu += $item->pagu->sum('anggaran');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->realisasi()->sum('realisasi'), 2, ',', '.') }}
                            @php
                                $realisasi += $item->realisasi()->sum('realisasi');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->sspb()->sum('nominal_sspb'), 2, ',', '.') }}
                            @php
                                $pengembalian += $item->sspb()->sum('nominal_sspb');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->pagu->sum('anggaran') - $item->realisasi()->sum('realisasi') + $item->sspb()->sum('nominal_sspb'), 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-center">
                            {{ number_format((($item->realisasi()->sum('realisasi') - $item->sspb()->sum('nominal_sspb')) * 100) / $item->pagu->sum('anggaran'), 2, ',', '.') }}%
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
