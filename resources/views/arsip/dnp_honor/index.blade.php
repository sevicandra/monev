@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">DNP Honorarium</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="{{ $base_url }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/cetak" target="_blank"
                class="btn btn-sm btn-neutral">Cetak</a>
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nama/NIP">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-dnp.honor :aksi="FALSE">
            @foreach ($data as $item)
                <tr class="whitespace-nowrap">
                    <x-table.body.column class="border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->nip }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->dasar }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->jabatan }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->gol }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->npwp }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->frekuensi }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ number_format($item->nilai, 0, ',', '.') }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ number_format($item->bruto, 0, ',', '.') }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ number_format($item->pajak, 0, ',', '.') }}</x-table.body.column>
                    <x-table.body.column
                        class="border">{{ number_format($item->netto, 0, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->bank }} {{ $item->norek }} <br> a.n.
                        {{ $item->namarek }}</x-table.body.column>
                </tr>
            @endforeach
        </x-dnp.honor>
    </div>
@endsection

@section('pagination')
@endsection
