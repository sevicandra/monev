@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi PPK {{ $ppk->nama }}</h1>
    </div>
    <div class="flex px-4 gap-2">
        <a href="/dashboard/ppk/{{ $ppk->id }}"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
            Tagihan</a>
        <a href="/dashboard/ppk/{{ $ppk->id }}?sp2d=ya"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
            SP2D</a>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse min-w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">Bulan</th>
                    <th class="border border-base-content">Realisasi</th>
                    <th class="border border-base-content">SSPB</th>
                    <th class="border border-base-content">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">
                            <a class="link link-neutral" target="_blank"
                                href="/dashboard/ppk/{{ $ppk->id }}/{{ $item->bulan }}?sp2d={{ request('sp2d') }}">
                                {{ $item->namabulan }}
                            </a>
                        </td>
                        <td class="border border-base-content text-end">
                            @if ($item->bulan)
                                <a class="link link-neutral"
                                    href="/dashboard/ppk/{{ $ppk->id }}/{{ $item->bulan }}/tagihan/?sp2d={{ request('sp2d') }}"
                                    target="_blank">
                                    Rp {{ number_format($item->total_realisasi, 2, ',', '.') }}
                                </a>
                            @else
                                <a class="link link-neutral"
                                    href="/dashboard/ppk/{{ $ppk->id }}/null/tagihan/?sp2d={{ request('sp2d') }}"
                                    target="_blank">
                                    Rp {{ number_format($item->total_realisasi, 2, ',', '.') }}
                                </a>
                            @endif
                        </td>
                        <td class="border border-base-content text-end">Rp {{ number_format($item->total_sspb, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-end">Rp
                            {{ number_format($item->total_realisasi - $item->total_sspb, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border border-base-content text-center">Total</td>
                    <td class="border border-base-content text-end">Rp {{ number_format($data->sum('total_realisasi'), 2, ',', '.') }}</td>
                    <td class="border border-base-content text-end">Rp {{ number_format($data->sum('total_sspb'), 2, ',', '.') }}</td>
                    <td class="border border-base-content text-end">Rp
                        {{ number_format($data->sum('total_realisasi') - $data->sum('total_sspb'), 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

    </div>
@endsection
