@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi Bulan {{ $bulan->namabulan }}</h1>
    </div>
    <div class="flex px-4 gap-2 justify-between">
        <span class="flex gap-2 overflow-x-hidden flex-wrap">
            <a href="/cleansing/realisasi-bulanan/01"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '01') @else btn-active @endif">01
            </a>
            <a href="/cleansing/realisasi-bulanan/02"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '02') @else btn-active @endif">02
            </a>
            <a href="/cleansing/realisasi-bulanan/03"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '03') @else btn-active @endif">03
            </a>
            <a href="/cleansing/realisasi-bulanan/04"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '04') @else btn-active @endif">04
            </a>
            <a href="/cleansing/realisasi-bulanan/05"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '05') @else btn-active @endif">05
            </a>
            <a href="/cleansing/realisasi-bulanan/06"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '06') @else btn-active @endif">06
            </a>
            <a href="/cleansing/realisasi-bulanan/07"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '07') @else btn-active @endif">07
            </a>
            <a href="/cleansing/realisasi-bulanan/08"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '08') @else btn-active @endif">08
            </a>
            <a href="/cleansing/realisasi-bulanan/09"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '09') @else btn-active @endif">09
            </a>
            <a href="/cleansing/realisasi-bulanan/10"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '10') @else btn-active @endif">10
            </a>
            <a href="/cleansing/realisasi-bulanan/11"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '11') @else btn-active @endif">11
            </a>
            <a href="/cleansing/realisasi-bulanan/12"
                class="btn-neutral btn btn-sm btn-outline @if ($bulan->kodebulan == '12') @else btn-active @endif">12
            </a>
        </span>
        <span>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-primary btn-sm btn-outline m-1">Download</div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="/cleansing/realisasi-bulanan/{{ $bulan->kodebulan }}/download">Download</a></li>
                    <li><a href="/cleansing/realisasi-bulanan/{{ $bulan->kodebulan }}/download-wix-table.body.column-sum">Download akumulatif</a></li>
                </ul>
            </div>
        </span>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse min-w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">Nomor</x-table.header.column>
                    <x-table.header.column class="border-x">POK</x-table.header.column>
                    <x-table.header.column class="border-x">Pagu</x-table.header.column>
                    <x-table.header.column class="border-x">Realisasi</x-table.header.column>
                    <x-table.header.column class="border-x">Pengembalian</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @php
                    $a=0;
                    $b=0;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
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
                    </tr>
                @endforeach
                <tr>
                    <x-table.body.column class="border"></x-table.body.column>
                    <x-table.body.column class="border"></x-table.body.column>
                    <x-table.body.column class="border text-end">{{ number_format($data->sum('anggaran'), 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($data->sum('total_realisasi'), 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-end">
                        {{ number_format($data->sum('total_sspb'), 2, ',', '.') }}</x-table.body.column>
                </tr>
            </x-table.body>
        </x-table>
    </div>
@endsection
