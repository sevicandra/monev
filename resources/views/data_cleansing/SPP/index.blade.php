@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">SPP Belum Input SP2D</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/cleansing/spp/download" class="btn btn-sm btn-neutral">Download Rekap</a>
            <a href="/cleansing/spp/import" class="btn btn-sm btn-neutral">Import</a>
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item" placeholder="Nomor Tagihan">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-tagihan :nomor_spm="false" :tanggal_spm="false" :nomor_sp2d="false" :tanggal_sp2d="false" :pic="false"
            :jenis="false" :status="false" :update="false" :aksi="false">
            @foreach ($data as $item)
                <tr class="whitespace-nowrap">
                    <x-table.body.column
                        class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->notagihan }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ indonesiaDate($item->tgltagihan) }}</x-table.body.column>
                    <x-table.body.column class="border"
                        style="white-space:normal; min-width:300px">{{ $item->uraian }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ optional($item->unit)->namaunit }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ optional($item->ppk)->nama }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ optional($item->dokumen)->namadokumen }}</x-table.body.column>
                    <x-table.body.column class="border text-right">
                        Rp{{ number_format(optional($item->realisasi)->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                </tr>
            @endforeach
        </x-tagihan>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection