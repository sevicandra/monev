@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi {{ $bulan->namabulan }}</h1>
    </div>
    <div class="flex flex-col gap-2">
        <div class="flex px-4 gap-2">
            @if ($bulan->kodebulan)
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}/tagihan"
                    class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') @else btn-active @endif">Per
                    Tagihan</a>
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}/tagihan?sp2d=ya"
                    class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
                    SP2D</a>
            @else
                <a href="/dashboard/unit/{{ $unit->id }}/{{ $bulan->kodebulan }}/tagihan?sp2d=ya"
                    class="btn-neutral btn btn-sm btn-outline @if (request('sp2d') === 'ya') btn-active @else @endif">Per
                    SP2D</a>
            @endif
        </div>
        <div class="flex px-4 gap-1">
            <a href="{{ request()->fullUrlWithQuery(['jns' => '']) }}"
                class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'ALL' ? 'btn-active' : '' }}">ALL</a>
            <a href="{{ request()->fullUrlWithQuery(['jns' => 'SPBY']) }}"
                class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'SPBY' ? 'btn-active' : '' }}">SPBY</a>
            <a href="{{ request()->fullUrlWithQuery(['jns' => 'SPP']) }}"
                class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'SPP' ? 'btn-active' : '' }}">SPP</a>
            <a href="{{ request()->fullUrlWithQuery(['jns' => 'KKP']) }}"
                class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'KKP' ? 'btn-active' : '' }}">KKP</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-realisasi.detail.tagihan>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border text-center">
                        @switch($item->jnstagihan)
                            @case('0')
                                SPBy
                            @break

                            @case('1')
                                SPP
                            @break

                            @case('2')
                                KKP
                            @break
                        @endswitch
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->notagihan }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->tgltagihan }}</x-table.body.column>
                    <x-table.body.column class="border ">
                        {{ $item->pok }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->realisasi, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($item->nominal_sspb, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->tanggal_sp2d }}</x-table.body.column>
                </tr>
            @endforeach
        </x-realisasi.detail.tagihan>
    </div>
@endsection
