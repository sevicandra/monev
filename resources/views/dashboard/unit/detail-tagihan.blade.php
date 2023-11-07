@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Realisasi {{ $bulan->namabulan }}</h1>
    </div>
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
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse min-w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">Nomor Tagihan</th>
                    <th class="border border-base-content">Tanggal Tagihan</th>
                    <th class="border border-base-content">POK</th>
                    <th class="border border-base-content">Realisasi</th>
                    <th class="border border-base-content">SSPB</th>
                    <th class="border border-base-content">Tanggal SP2D</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content text-center">
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
                        </td>
                        <td class="border border-base-content text-center">{{ $item->notagihan }}</td>
                        <td class="border border-base-content text-center">{{ $item->tgltagihan }}</td>
                        <td class="border border-base-content ">
                            {{ $item->pok }}
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->realisasi, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-end">
                            {{ number_format($item->nominal_sspb, 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content ">{{ $item->tanggal_sp2d }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
