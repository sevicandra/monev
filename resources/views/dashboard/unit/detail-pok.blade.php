@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi Bulan {{ $bulan->namabulan }}</h1>
    </div>
    <div class="flex px-4 gap-2">
        <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
            Tagihan</a>
        <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}?sp2d=ya"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
            SP2D</a>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-realisasi.detail.pok>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column
                        class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">
                        {{ $item->pok }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->anggaran, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->total_realisasi, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->total_sspb, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->anggaran - $item->total_realisasi + $item->total_sspb, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        {{ number_format((($item->total_realisasi - $item->total_sspb) * 100) / $item->anggaran, 2, ',', '.') }}%
                    </x-table.body.column>
                </tr>
            @endforeach
            <tr>
                <x-table.body.column class="border "></x-table.body.column>
                <x-table.body.column class="border "></x-table.body.column>
                <x-table.body.column
                    class="border text-end">{{ number_format($data->sum('anggaran'), 2, ',', '.') }}
                </x-table.body.column>
                <x-table.body.column class="border text-end">
                    {{ number_format($data->sum('total_realisasi'), 2, ',', '.') }}</x-table.body.column>
                <x-table.body.column
                    class="border text-end">{{ number_format($data->sum('total_sspb'), 2, ',', '.') }}
                </x-table.body.column>
                <x-table.body.column class="border text-end">
                    {{ number_format($data->sum('anggaran') - $data->sum('total_realisasi') + $data->sum('total_sspb'), 2, ',', '.') }}
                </x-table.body.column>
                <x-table.body.column class="border text-center">
                    {{ number_format((($data->sum('total_realisasi') - $data->sum('total_sspb')) * 100) / $data->sum('anggaran'), 2, ',', '.') }}%
                </x-table.body.column>
            </tr>
        </x-realisasi.detail.pok>
    </div>
@endsection
