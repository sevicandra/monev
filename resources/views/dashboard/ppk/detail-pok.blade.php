@extends('layout.main')
@section('content')
        <div class="bg-primary p-4">
            <h1 class="text-xl text-primary-content">Realisasi Bulan {{ $bulan->namabulan }}</h1>
        </div>
        <div class="flex px-4 gap-2">
            <a href="/dashboard/ppk/{{ $ppk->id }}/{{ $bulan->kodebulan }}"
                class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
                Tagihan</a>
            <a href="/dashboard/ppk/{{ $ppk->id }}/{{ $bulan->kodebulan }}?sp2d=ya"
                class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
                SP2D</a>
        </div>
        <div class="px-4 gap-2 overflow-y-auto">
            <table class="table border-collapse min-w-full">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th class="border border-base-content">Nomor</th>
                        <th class="border border-base-content">POK</th>
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
                    @foreach ($data as $item)
                        <tr>
                            <td class="border border-base-content text-center">{{ $i }}</td>
                            <td class="border border-base-content">
                                {{ $item->pok }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($item->anggaran, 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($item->realisasi, 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($item->total_sspb, 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-end">
                                {{ number_format($item->anggaran - $item->realisasi + $item->total_sspb, 2, ',', '.') }}
                            </td>
                            <td class="border border-base-content text-center">
                                {{ number_format((($item->realisasi - $item->total_sspb) * 100) / $item->anggaran, 2, ',', '.') }}%
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                    <tr>
                        <th class="border border-base-content"></th>
                        <th class="border border-base-content"></th>
                        <th class="border border-base-content text-end">{{ number_format($data->sum('anggaran'), 2, ',', '.') }}</th>
                        <th class="border border-base-content text-end">{{ number_format($data->sum('realisasi'), 2, ',', '.') }}</th>
                        <th class="border border-base-content text-end">{{ number_format($data->sum('total_sspb'), 2, ',', '.') }}</th>
                        <th class="border border-base-content text-end">
                            {{ number_format($data->sum('anggaran') - $data->sum('realisasi') + $data->sum('total_sspb'), 2, ',', '.') }}
                        </th>
                        <th class="border border-base-content text-center">
                            {{ number_format((($data->sum('realisasi') - $data->sum('total_sspb')) * 100) / $data->sum('anggaran'), 2, ',', '.') }}%
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
@endsection
