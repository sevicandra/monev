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
        <x-realisasi :unit="false">
            @php
            $pagu = 0;
            $realisasi = 0;
            $pengembalian = 0;
            $i = 1;
        @endphp
        @foreach ($ppk as $item)
            <tr>
                <x-table.body.column class="border text-center">{{ $i }}</x-table.body.column>
                <x-table.body.column class="border ">
                    <a class="link link-base-content" href="ppk/{{ $item->id }}">{{ $item->nama }}</a>
                </x-table.body.column>
                <x-table.body.column class="border text-end">
                    {{ number_format($item->paguppk->sum('anggaran'), 2, ',', '.') }}
                    @php
                        $pagu += $item->paguppk->sum('anggaran');
                    @endphp
                </x-table.body.column>
                <x-table.body.column class="border text-end">
                    @php
                        $realisasiPpk = 0;
                        if (request('sp2d') === 'ya') {
                            foreach ($item->paguppk as $detailPagu) {
                                foreach ($detailPagu->realisasi as $detailRealisasi) {
                                    if ($detailRealisasi->tagihan?->spm != null) {
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
                </x-table.body.column>
                <x-table.body.column class="border text-end">
                    @php
                        $pengembalianPpk = 0;
                        if (request('sp2d') === 'ya') {
                            foreach ($item->paguppk as $detailPagu) {
                                foreach ($detailPagu->sspb as $detailSSPB) {
                                    if ($detailSSPB->tagihan?->spm != null) {
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
                </x-table.body.column>
                <x-table.body.column class="border text-end">
                    {{ number_format($item->paguppk->sum('anggaran') - $realisasiPpk + $pengembalianPpk, 2, ',', '.') }}
                </x-table.body.column>
                <x-table.body.column class="border text-center">
                    @if ($item->paguppk->sum('anggaran') != 0)
                        {{ number_format((($realisasiPpk - $pengembalianPpk) * 100) / $item->paguppk->sum('anggaran'), 2, ',', '.') }}%
                    @else
                        0%
                    @endif
                </x-table.body.column>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
        <tr>
            <x-table.body.column class="border text-center" colspan="2">Jumlah</x-table.body.column>
            <x-table.body.column class="border text-end"> {{ number_format($pagu, 2, ',', '.') }} </x-table.body.column>
            <x-table.body.column class="border text-end"> {{ number_format($realisasi, 2, ',', '.') }} </x-table.body.column>
            <x-table.body.column class="border text-end"> {{ number_format($pengembalian, 2, ',', '.') }} </x-table.body.column>
            <x-table.body.column class="border text-end">
                {{ number_format($pagu + $realisasi - $pengembalian, 2, ',', '.') }}</x-table.body.column>
            <x-table.body.column class="border text-center">
                @if ($pagu != 0)
                    {{ number_format((($realisasi - $pengembalian) * 100) / $pagu, 2, ',', '.') }}%
                @else
                    0%
                @endif
            </x-table.body.column>
        </tr>
        </x-realisasi>
    </div>
@endsection
