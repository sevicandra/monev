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
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/import-monev" class="btn btn-sm btn-neutral">Import DB Monev</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/import-excel" class="btn btn-sm btn-neutral">Import Excel</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll/cetak" class="btn btn-sm btn-neutral" target="_blank">Cetak</a>
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
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">Nomor Rekening</th>
                    <th class="border border-base-content">Nama Bank</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Pajak</th>
                    <th class="border border-base-content">Adm.</th>
                    <th class="border border-base-content">Netto</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i++ }}</td>
                        <td class="border border-base-content">{{ $item->nama }}</td>
                        <td class="border border-base-content">{{ $item->norek }}</td>
                        <td class="border border-base-content">{{ $item->bank }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->bruto, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->pajak, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->admin, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->netto, 2, ',', '.') }}</td>
                        <td class="border border-base-content">
                            <div class="join">
                                <a class="btn btn-xs btn-primary btn-outline join-item" href="/tagihan-blbi/{{ $item->tagihan_id }}/payroll/{{ $item->id }}/edit">Edit</a>
                                <form action="/tagihan-blbi/{{ $item->tagihan_id }}/payroll/{{ $item->id }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-error btn-outline join-item"
                                        onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                </form>
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