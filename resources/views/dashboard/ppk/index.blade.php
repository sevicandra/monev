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
                            @php
                                $realisasiPpk = 0;
                                if (request('sp2d') === 'ya') {
                                    foreach ($item->paguppk as $detailPagu) {
                                        foreach ($detailPagu->realisasi as $detailRealisasi) {
                                            if ($detailRealisasi->tagihan->nomor_sp2d != null && $detailRealisasi->tagihan->tanggal_sp2d != null) {
                                                $realisasiPpk += $detailRealisasi->realisasi;
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($item->paguppk as $detailPagu) {
                                        foreach ($detailPagu->realisasi as $detailRealisasi) {
                                            $realisasiPpk += $detailRealisasi->realisasi;
                                        }
                                    }
                                }
                                $realisasi += $realisasiPpk;
                            @endphp
                            {{ number_format($realisasiPpk, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-end">
                            @php
                                $pengembalianPpk = 0;
                                if (request('sp2d') === 'ya') {
                                    foreach ($item->paguppk as $detailPagu) {
                                        foreach ($detailPagu->sspb as $detailSSPB) {
                                            if ($detailSSPB->tagihan->nomor_sp2d != null && $detailSSPB->tagihan->tanggal_sp2d != null) {
                                                $pengembalianPpk += $detailSSPB->nominal_sspb;
                                            }
                                        }
                                    }
                                } else {
                                    foreach ($item->paguppk as $detailPagu) {
                                        foreach ($detailPagu->sspb as $detailSSPB) {
                                            $pengembalianPpk += $detailSSPB->nominal_sspb;
                                        }
                                    }
                                }
                                $pengembalian += $pengembalianPpk;
                            @endphp
                            {{ number_format($pengembalianPpk, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->paguppk->sum('anggaran') - $realisasiPpk + $pengembalianPpk, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-center">
                            @if ($item->paguppk->sum('anggaran') != 0)
                                {{ number_format((($realisasiPpk - $pengembalianPpk) * 100) / $item->paguppk->sum('anggaran'), 2, ',', '.') }}%
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
