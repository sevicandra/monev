@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi</h1>
    </div>
    <div class="flex px-4 gap-2">
        <a href="/dashboard"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
            Tagihan</a>
        <a href="/dashboard?sp2d=ya"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
            SP2D</a>
    </div>
    <div class="lg:flex lg:flex-row px-4 gap-2 overflow-y-auto">
        <div class="lg:basis-8/12 w-full overflow-hidden lg:max-h-full flex flex-col gap-2">
            <div class="overflow-x-auto flex flex-col shrink-0">
                <table class="table border-collapse min-w-full whitespace-nowrap">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th class="border border-base-content">No.</th>
                            <th class="border border-base-content">Jenis Belanja</th>
                            <th class="border border-base-content">Pagu</th>
                            <th class="border border-base-content">Realisasi</th>
                            <th class="border border-base-content">Sisa Pagu</th>
                            <th class="border border-base-content">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-base-content text-center">1</td>
                            <td class="border border-base-content">Belanja Pegawai</td>
                            <td class="border border-base-content text-end">
                                {{ number_format($belanjapegawai->sum('total_anggaran'), 2, ',', '.') }}</td>
                            <td class="border border-base-content text-end">
                                {{ number_format($realisasibelanjapegawai->sum('realisasi') - $realisasibelanjapegawai->sum('nominal_sspb'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($belanjapegawai->sum('total_anggaran') - $realisasibelanjapegawai->sum('realisasi') + $realisasibelanjapegawai->sum('nominal_sspb'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                @if ($realisasibelanjapegawai->sum('realisasi'))
                                    {{ number_format((($realisasibelanjapegawai->sum('realisasi') - $realisasibelanjapegawai->sum('nominal_sspb')) * 100) / $belanjapegawai->sum('total_anggaran'), 2, ',', '.') }}%
                                @else
                                    0,00%
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-base-content text-center">2</td>
                            <td class="border border-base-content">Belanja Barang</td>
                            <td class="border border-base-content text-end">
                                {{ number_format($belanjabarang->sum('total_anggaran'), 2, ',', '.') }}</td>
                            <td class="border border-base-content text-end">
                                {{ number_format($realisasibelanjabarang->sum('realisasi') - $realisasibelanjabarang->sum('nominal_sspb'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($belanjabarang->sum('total_anggaran') - $realisasibelanjabarang->sum('realisasi') + $realisasibelanjabarang->sum('nominal_sspb'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                @if ($realisasibelanjabarang->sum('realisasi'))
                                    {{ number_format((($realisasibelanjabarang->sum('realisasi') - $realisasibelanjabarang->sum('nominal_sspb')) * 100) / $belanjabarang->sum('total_anggaran'), 2, ',', '.') }}%
                                @else
                                    0,00%
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-base-content text-center">3</td>
                            <td class="border border-base-content">Belanja Modal</td>
                            <td class="border border-base-content text-end">
                                {{ number_format($belanjamodal->sum('total_anggaran'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($realisasibelanjamodal->sum('realisasi') - $realisasibelanjamodal->sum('nominal_sspb'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($belanjamodal->sum('total_anggaran') - $realisasibelanjamodal->sum('realisasi') + $realisasibelanjamodal->sum('nominal_sspb'), 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                @if ($realisasibelanjamodal->sum('realisasi'))
                                    {{ number_format((($realisasibelanjamodal->sum('realisasi') - $realisasibelanjamodal->sum('nominal_sspb')) * 100) / $belanjamodal->sum('total_anggaran'), 2, ',', '.') }}%
                                @else
                                    0,00%
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mb-3 mr-1 ml-1  lg:flex lg:flex-col overflow-y-auto">
                <div class="text-center text-lg font-bold">Realisasi Per Unit</div>
                @foreach ($unit as $item)
                    @php
                        $realisasi = 0;
                        if (request('sp2d') === 'ya') {
                            foreach ($item->pagu as $detailPagu) {
                                foreach ($detailPagu->realisasi as $detailRealisasi) {
                                    if ($detailRealisasi->tagihan->nomor_sp2d != null && $detailRealisasi->tagihan->tanggal_sp2d != null) {
                                        $realisasi += $detailRealisasi->realisasi;
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
                                    $realisasi += $detailRealisasi->realisasi;
                                }
                                foreach ($detailPagu->sspb as $detailSSPB) {
                                    $realisasi -= $detailSSPB->nominal_sspb;
                                }
                            }
                        }
                    @endphp
                    <div class="tooltip w-full border-b"
                        data-tip="{{ $realisasi * 100 / $item->pagu->sum('anggaran') }}%"
                    >
                        <progress class="progress progress-info w-full"
                            value="{{ $realisasi * 100 / $item->pagu->sum('anggaran') }}"
                            max="100"></progress>
                        <div class="text-start">
                            {{ $item->namaunit }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="lg:basis-4/12">
            <table class="table table-sm border border-base-content border-collapse w-full">
                <tr class="border border-base-content">
                    <th class="text-start">Realisasi per PPK</th>
                    <th class="text-end">Persentase</th>
                </tr>
                @foreach ($ppk as $item)
                    <tr class="border border-base-content">
                        <td class="text-start">{{ $item->nama }}</td>
                        <td class="text-end">
                            @if ($item->paguppk->sum('anggaran') != 0)
                                @php
                                    $realisasi = 0;
                                    if (request('sp2d') === 'ya') {
                                        foreach ($item->paguppk as $detailPagu) {
                                            foreach ($detailPagu->realisasi as $detailRealisasi) {
                                                if ($detailRealisasi->tagihan->nomor_sp2d != null && $detailRealisasi->tagihan->tanggal_sp2d != null) {
                                                    $realisasi += $detailRealisasi->realisasi;
                                                }
                                            }
                                            foreach ($detailPagu->sspb as $detailSSPB) {
                                                if ($detailSSPB->tagihan->nomor_sp2d != null && $detailSSPB->tagihan->tanggal_sp2d != null) {
                                                    $realisasi -= $detailSSPB->nominal_sspb;
                                                }
                                            }
                                        }
                                    } else {
                                        foreach ($item->paguppk as $detailPagu) {
                                            foreach ($detailPagu->realisasi as $detailRealisasi) {
                                                $realisasi += $detailRealisasi->realisasi;
                                            }
                                            foreach ($detailPagu->sspb as $detailSSPB) {
                                                $realisasi -= $detailSSPB->nominal_sspb;
                                            }
                                        }
                                    }
                                @endphp
                                <div class="badge badge-info">
                                    {{ number_format(($realisasi * 100) / $item->paguppk->sum('anggaran'), 2, ',', '.') }}%
                                </div>
                            @else
                                <div class="badge badge-info">
                                    0%
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('foot')
@endsection
