@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi Per Unit</h1>
    </div>
    <div class="">
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
        <x-realisasi :ppk="false">
            @php
                $pagu = 0;
                $realisasi = 0;
                $pengembalian = 0;
                $i = 1;
            @endphp
            @foreach ($unit as $item)
                <tr>
                    <x-table.body.column class="border text-center">{{ $i }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <a class="link link-base-content" href="unit/{{ $item->id }}">{{ $item->namaunit }}</a>
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->pagu->sum('anggaran'), 2, ',', '.') }}
                        @php
                            $pagu += $item->pagu->sum('anggaran');
                        @endphp
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        @php
                            $realisasiUnit = 0;
                            if (request('sp2d') === 'ya') {
                                foreach ($item->pagu as $detailPagu) {
                                    foreach ($detailPagu->realisasi as $detailRealisasi) {
                                        if ($detailRealisasi->tagihan?->spm != null) {
                                            $realisasiUnit += $detailRealisasi->realisasi;
                                        }
                                    }
                                }
                            } else {
                                foreach ($item->pagu as $detailPagu) {
                                    foreach ($detailPagu->realisasi as $detailRealisasi) {
                                        $realisasiUnit += $detailRealisasi->realisasi;
                                    }
                                }
                            }
                            $realisasi += $realisasiUnit;
                        @endphp
                        {{ number_format($realisasiUnit, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        @php
                            $pengembalianUnit = 0;
                            if (request('sp2d') === 'ya') {
                                foreach ($item->pagu as $detailPagu) {
                                    foreach ($detailPagu->sspb as $detailSSPB) {
                                        if ($detailSSPB->tagihan?->spm != null) {
                                            $pengembalianUnit += $detailSSPB->nominal_sspb;
                                        }
                                    }
                                }
                            } else {
                                foreach ($item->pagu as $detailPagu) {
                                    foreach ($detailPagu->sspb as $detailSSPB) {
                                        $pengembalianUnit += $detailSSPB->nominal_sspb;
                                    }
                                }
                            }
                            $pengembalian += $pengembalianUnit;
                        @endphp
                        {{ number_format($pengembalianUnit, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->pagu->sum('anggaran') - $realisasiUnit + $pengembalianUnit, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        {{ number_format((($realisasiUnit - $pengembalianUnit) * 100) / $item->pagu->sum('anggaran'), 2, ',', '.') }}%
                    </x-table.body.column>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <x-table.body.column class="border text-center" colspan="2">Jumlah</x-table.body.column>
                <x-table.body.column class="border text-end"> {{ number_format($pagu, 2, ',', '.') }} </x-table.body.column>
                <x-table.body.column class="border text-end"> {{ number_format($realisasi, 2, ',', '.') }}
                </x-table.body.column>
                <x-table.body.column class="border text-end"> {{ number_format($pengembalian, 2, ',', '.') }}
                </x-table.body.column>
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
