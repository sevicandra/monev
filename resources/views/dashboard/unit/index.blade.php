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
                            <a class="link link-base-content" href="unit/{{ $item->id }}">{{ $item->namaunit }}</a>
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->pagu->sum('anggaran'), 2, ',', '.') }}
                            @php
                                $pagu += $item->pagu->sum('anggaran');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            @php
                                $realisasiUnit = 0;
                                if (request('sp2d') === 'ya') {
                                    foreach ($item->pagu as $detailPagu) {
                                        foreach ($detailPagu->realisasi as $detailRealisasi) {
                                            if ($detailRealisasi->tagihan->nomor_sp2d != null && $detailRealisasi->tagihan->tanggal_sp2d != null) {
                                                $realisasiUnit += $detailRealisasi->realisasi;
                                            }
                                        }
                                        foreach ($detailPagu->sspb as $detailSSPB) {
                                            if ($detailSSPB->tagihan->nomor_sp2d != null && $detailSSPB->tagihan->tanggal_sp2d != null) {
                                                $realisasi -= $detailSSPB->nominal_sspb;
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($item->pagu as $detailPagu) {
                                        foreach ($detailPagu->realisasi as $detailRealisasi) {
                                            $realisasiUnit += $detailRealisasi->realisasi;
                                        }
                                        foreach ($detailPagu->sspb as $detailSSPB) {
                                            $realisasi -= $detailSSPB->nominal_sspb;
                                        }
                                    }
                                }
                                $realisasi += $realisasiUnit;
                            @endphp
                            {{ number_format($realisasiUnit, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-end">
                            @php
                                $pengembalianUnit = 0;
                                if (request('sp2d') === 'ya') {
                                    foreach ($item->pagu as $detailPagu) {
                                        foreach ($detailPagu->sspb as $detailSSPB) {
                                            if ($detailSSPB->tagihan->nomor_sp2d != null && $detailSSPB->tagihan->tanggal_sp2d != null) {
                                                $pengembalian += $detailSSPB->nominal_sspb;
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($item->pagu as $detailPagu) {
                                        foreach ($detailPagu->sspb as $detailSSPB) {
                                            $pengembalian += $detailSSPB->nominal_sspb;
                                        }
                                    }
                                }
                                $pengembalian += $realisasiUnit;
                            @endphp
                            {{ number_format($pengembalian, 2, ',', '.') }}
                            @php
                                $pengembalian += $item->sspb()->sum('nominal_sspb');
                            @endphp
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->pagu->sum('anggaran') - $realisasiUnit + $pengembalianUnit, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-center">
                            {{ number_format((($realisasiUnit - $pengembalianUnit) * 100) / $item->pagu->sum('anggaran'), 2, ',', '.') }}%
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
                    <th class="border border-base-content text-end">
                        {{ number_format($pagu + $realisasi - $pengembalian, 2, ',', '.') }}</th>
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
