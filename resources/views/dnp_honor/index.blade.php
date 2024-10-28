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
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/create" class="btn btn-sm btn-neutral">Tambah</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/import" class="btn btn-sm btn-neutral">Import</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/cetak" target="_blank"
                class="btn btn-sm btn-neutral">Cetak</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/create-payroll"
                class="btn btn-sm btn-neutral">Generate Payroll</a>
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
        <x-dnp.honor>
            @foreach ($data as $item)
                <tr>
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
                    <x-table.body.column class="border whitespace-nowrap">{{ $item->bank }} {{ $item->norek }} <br>
                        a.n.
                        {{ $item->namarek }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <div class="join">
                            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/{{ $item->id }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">Edit</a>
                            <form action="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-dnp.honor>
    </div>
@endsection

@section('pagination')
@endsection
