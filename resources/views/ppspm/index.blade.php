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
                            placeholder="Nomor Tagihan/Uraian">
                        <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-tagihan :jenis="false" :status="false" :update="false" :uraian="false" :nomor_spm="false" :tanggal_spm="false" :nomor_sp2d="false" :tanggal_sp2d="false" :pic="false">
            @foreach ($data as $item)
                <tr class="whitespace-nowrap">
                    <x-table.body.column class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->notagihan }}</x-table.body.column>
                    <x-table.body.column class="border">{{ indonesiaDate($item->tgltagihan) }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->unit)->namaunit }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->ppk)->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->dokumen)->namadokumen }}</x-table.body.column>
                    <x-table.body.column class="border text-right">
                        Rp{{ number_format(optional($item->realisasi)->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <div class="join">
                            <a href="/ppspm/{{ $item->id }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">Detail</a>
                            <a href="/ppspm/{{ $item->id }}/tolak" class="btn btn-xs btn-outline btn-error join-item"
                                onclick="return confirm('Apakah Anda yakin akan menolak data ini?');">Tolak</a>
                            <a href="/ppspm/{{ $item->id }}/approve"
                                class="btn btn-xs btn-outline btn-success join-item"
                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
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
