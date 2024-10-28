@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi Unit {{ $unit->namaunit }}</h1>
    </div>
    <div class="flex px-4 gap-2">
        <a href="/dashboard/unit/{{ $unit->id }}"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
            Tagihan</a>
        <a href="/dashboard/unit/{{ $unit->id }}?sp2d=ya"
            class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
            SP2D</a>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-realisasi.detail>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="border text-center">
                        <a class="link link-base-content" target="_blank"
                            href="/dashboard/unit/{{ $unit->id }}/{{ $item->bulan }}?sp2d={{ request('sp2d') }}">
                            {{ $item->namabulan }}
                        </a>
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        @if ($item->bulan)
                            <a class="link link-base-content"
                                href="/dashboard/unit/{{ $unit->id }}/{{ $item->bulan }}/tagihan/?sp2d={{ request('sp2d') }}"
                                target="_blank">
                                Rp {{ number_format($item->total_realisasi, 2, ',', '.') }}
                            </a>
                        @else
                            <a class="link link-base-content"
                                href="/dashboard/unit/{{ $unit->id }}/null/tagihan/?sp2d={{ request('sp2d') }}"
                                target="_blank">
                                Rp {{ number_format($item->total_realisasi, 2, ',', '.') }}
                            </a>
                        @endif
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">Rp {{ number_format($item->total_sspb, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">Rp
                        {{ number_format($item->total_realisasi - $item->total_sspb, 2, ',', '.') }}</x-table.body.column>
                </tr>
            @endforeach
            <tr>
                <x-table.body.column class="border text-center">Total</x-table.body.column>
                <x-table.body.column class="border text-end">Rp
                    {{ number_format($data->sum('total_realisasi'), 2, ',', '.') }}</x-table.body.column>
                <x-table.body.column class="border text-end">Rp
                    {{ number_format($data->sum('total_sspb'), 2, ',', '.') }}</x-table.body.column>
                <x-table.body.column class="border text-end">Rp
                    {{ number_format($data->sum('total_realisasi') - $data->sum('total_sspb'), 2, ',', '.') }}</x-table.body.column>
            </tr>
        </x-realisasi.detail>
    </div>
@endsection
