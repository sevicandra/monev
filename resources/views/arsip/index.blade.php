@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Arsip</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Tagihan">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Tgl SPM</th>
                    <th class="border border-base-content">No SP2D</th>
                    <th class="border border-base-content">Tgl SP2D</th>
                    <th class="border border-base-content">Unit</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Jenis Dokumen</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Status</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr style="white-space:nowrap">
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
                        <td class="border border-base-content">{{ indonesiaDate($item->tgltagihan) }}</td>
                        <td class="border border-base-content">
                            {{ indonesiaDate($item->tanggal_spm) }}
                        </td>
                        <td class="border border-base-content">
                            {{ $item->nomor_sp2d }}
                        </td>
                        <td class="border border-base-content">
                            {{ indonesiaDate($item->tanggal_sp2d) }}
                        </td>
                        <td class="border border-base-content">{{ optional($item->unit)->namaunit }}</td>
                        <td class="border border-base-content">{{ optional($item->ppk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->dokumen)->namadokumen }}</td>
                        <td class="border border-base-content text-right">
                            Rp{{ number_format(optional($item->realisasi)->sum('realisasi'), 2, ',', '.') }}</td>
                        <td class="border border-base-content text-center">
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
                        </td>
                        <td class="border border-base-content">
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
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ $data->links() }}
        </div>
    </div>
@endsection
