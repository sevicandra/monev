@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Payroll</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/tagihan-blbi" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/create" class="btn btn-sm btn-neutral">Tambah</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/import-hris" class="btn btn-sm btn-neutral">Import DB HRIS</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/import-monev" class="btn btn-sm btn-neutral">Import DB
                Monev</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/import-excel" class="btn btn-sm btn-neutral">Import Excel</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/cetak" class="btn btn-sm btn-neutral"
                target="_blank">Cetak</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nama Pegawai">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-payroll>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->norek }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->bank }}</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format($item->pajak, 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format($item->admin, 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format($item->netto, 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <div class="join">
                            <a class="btn btn-xs btn-primary btn-outline join-item"
                                href="/tagihan-blbi/{{ $item->tagihan_id }}/payroll/{{ $item->id }}/edit">Edit</a>
                            <form action="/tagihan-blbi/{{ $item->tagihan_id }}/payroll/{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-error btn-outline join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-payroll>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
