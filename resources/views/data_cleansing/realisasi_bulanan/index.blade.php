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
                    <li><a href="/cleansing/realisasi-bulanan/{{ $bulan->kodebulan }}/download-with-sum">Download akumulatif</a></li>
                </ul>
            </div>
        </span>
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
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content ">
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
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
                <tr>
                    <th class="border border-base-content "></th>
                    <th class="border border-base-content "></th>
                    <th class="border border-base-content text-end">{{ number_format($data->sum('anggaran'), 2, ',', '.') }}
                    </th>
                    <th class="border border-base-content text-end">
                        {{ number_format($data->sum('realisasi'), 2, ',', '.') }}</th>
                    <th class="border border-base-content text-end">
                        {{ number_format($data->sum('total_sspb'), 2, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
