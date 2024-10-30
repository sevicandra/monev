@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Arsip</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex gap-2 flex-col">
        <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
            <div>
                <div class="flex gap-1">
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
            <div>
                <form action="" method="get" autocomplete="off">
                    <input type="hidden" name="jns" value="{{ request('jns', 'ALL') }}">
                    <input type="hidden" name="sb" value="{{ request('sb', 'nomor_tagihan') }}">
                    <input type="hidden" name="sd" value="{{ request('sd', 'desc') }}">
                    <div class="join">
                        <input type="text" name="search" class="input input-sm input-bordered join-item"
                            placeholder="Nomor Tagihan/Uraian">
                        <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
            <div>
                <a class="btn btn-sm btn-neutral" href="{{ route('arsip-tagihan.download', request()->all()) }}">Download
                    Rekap</a>
            </div>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-tagihan :pic="false" :update="false">
            @foreach ($data as $item)
                <tr style="white-space:nowrap">
                    <x-table.body.column
                        class="border text-center">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</x-table.body.column>
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
                    <x-table.body.column
                        class="border text-center">{{ indonesiaDate($item->tgltagihan) }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->uraian }}</x-table.body.column>
                    <x-table.body.column class="border text-center">
                        {{ optional($item->spm)->nomor_spm }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        {{ indonesiaDate(optional($item->spm)->tanggal_spm) }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        {{ optional($item->spm)->nomor_sp2d }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        {{ indonesiaDate(optional($item->spm)->tanggal_sp2d) }}
                    </x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->unit)->namaunit }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->ppk)->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->dokumen)->namadokumen }}</x-table.body.column>
                    <x-table.body.column class="border text-right">
                        Rp{{ number_format(optional($item->realisasi)->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-center">
                        @switch($item->status)
                            @case(0)
                                Staf PPK
                            @break

                            @case(2)
                                Verifikator
                            @break

                            @case(3)
                                PPSPM
                            @break

                            @case(4)
                                Bendahara
                            @break

                            @case(5)
                                Arsip
                            @break

                            @default
                        @endswitch
                    </x-table.body.column>
                    <x-table.body.column class="border">
                        <div class="join">
                            @if ($item->status > 4)
                                @can('admin_satker', auth()->user()->id)
                                    <a href="/arsip/{{ $item->id }}/tolak"
                                        class="btn btn-xs btn-outline btn-error join-item"
                                        onclick="return confirm('Apakah Anda yakin akan menolak data ini?');">Tolak</a>
                                @endcan
                            @endif
                            @if ($item->dokumen->statusdnp === '1')
                                <a href="/arsip/{{ $item->id }}/dnp"
                                    class="btn btn-xs btn-outline btn-neutral join-item">DNP</a>
                            @endif
                            <a href="/arsip/{{ $item->id }}/coa"
                                class="btn btn-xs btn-outline btn-neutral join-item">COA</a>
                            <a href="/arsip/{{ $item->id }}/payroll"
                                class="btn btn-xs btn-outline btn-neutral join-item">Payroll</a>
                            @if ($item->dokumen->dnp_perjadin)
                                <a href="/arsip/{{ $item->id }}/dnp-perjadin"
                                    class="btn btn-xs btn-neutral btn-outline join-item">DNP Perjadin</a>
                            @endif
                            @if ($item->dokumen->dnp_honor)
                                <a href="/arsip/{{ $item->id }}/dnp-honorarium"
                                    class="btn btn-xs btn-neutral btn-outline join-item">DNP Honor</a>
                            @endif
                            @if ($item->dokumen->statusrekanan === '1')
                                <a href="/arsip/{{ $item->id }}/rekanan"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Rekanan</a>
                            @endif
                            <a href="/arsip/{{ $item->id }}/dokumen"
                                class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                            <a href="/arsip/{{ $item->id }}/riwayat"
                                class="btn btn-xs btn-outline btn-neutral join-item">Riwayat</a>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-tagihan>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
