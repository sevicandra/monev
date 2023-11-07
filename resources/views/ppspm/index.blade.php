@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPSPM</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="col-lg-7">
        </div>
        <div class="col-lg-5">
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
                    <th class="border border-base-content">Unit</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Jenis Dokumen</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <td class="text-center border border-base-content">{{ $i++ }}</td>
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
                            @if (isset($item->spm))
                                {{ indonesiaDate($item->spm->tanggal_spm) }}
                            @endif
                        </td>
                        <td class="border border-base-content">{{ $item->unit->namaunit }}</td>
                        <td class="border border-base-content">{{ $item->ppk->nama }}</td>
                        <td class="border border-base-content">{{ $item->dokumen->namadokumen }}</td>
                        <td class="border border-base-content text-right">
                            Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                        <td class="border border-base-content">
                            <div class="join">
                                <a href="/ppspm/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral join-item">detail</a>
                                @if ($item->jnstagihan === '1')
                                    <a href="/ppspm/{{ $item->id }}/edit"
                                        class="btn btn-xs btn-outline btn-neutral join-item">SPM</a>
                                @endif
                                <a href="/ppspm/{{ $item->id }}/tolak"
                                    class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menolak data ini?');">Tolak</a>
                                <a href="/ppspm/{{ $item->id }}/approve"
                                    class="btn btn-xs btn-outline btn-success join-item"
                                    onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
