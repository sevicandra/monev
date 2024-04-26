@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Bendahara</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Tagihan/Uraian">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full relative">
            <thead class="text-center sticky">
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
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1 + ($data->currentPage() - 1) * $data->perPage();
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
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
                        <td class="border border-base-content">{{ $item->notagihan }}</td>
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
                            <div class="join">
                                <a href="/bendahara/{{ $item->id }}/sp2d"
                                    class="btn btn-xs btn-outline btn-neutral join-item">SP2D</a>
                                <a href="/bendahara/{{ $item->id }}/dokumen"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                                {{-- @if ($item->dokumen->statusdnp === '1')
                                        <a href="/bendahara/{{ $item->id }}/payroll" class="btn btn-xs btn-outline btn-neutral join-item">Payroll</a>
                                        @endif --}}
                                <a href="/bendahara/{{ $item->id }}/payroll"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Payroll</a>
                                @if ($item->dokumen->dnp_perjadin)
                                    <a href="/bendahara/{{ $item->id }}/dnp-perjadin"
                                        class="btn btn-xs btn-neutral btn-outline join-item">DNP Perjadin</a>
                                @endif
                                @if ($item->dokumen->dnp_honor)
                                    <a href="/bendahara/{{ $item->id }}/dnp-honorarium"
                                        class="btn btn-xs btn-neutral btn-outline join-item">DNP Honor</a>
                                @endif
                                <a href="/bendahara/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral join-item">COA</a>
                                @if ($item->dokumen->statusrekanan === '1')
                                    <a href="/bendahara/{{ $item->id }}/rekanan"
                                        class="btn btn-xs btn-outline btn-neutral join-item">Rekanan</a>
                                @endif
                                <a href="/bendahara/{{ $item->id }}/tolak"
                                    class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menolak data ini?');">Tolak</a>
                                <a href="/bendahara/{{ $item->id }}/approve"
                                    class="btn btn-xs btn-outline btn-success join-item"
                                    onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
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
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
