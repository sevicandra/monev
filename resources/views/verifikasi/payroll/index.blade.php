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
            <a href="/verifikasi" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/verifikasi/{{ $tagihan->id }}/payroll/create" class="btn btn-sm btn-neutral">Tambah</a>
            <a href="/verifikasi/{{ $tagihan->id }}/payroll/import-hris" class="btn btn-sm btn-neutral">Import DB HRIS</a>
            <a href="/verifikasi/{{ $tagihan->id }}/payroll/import-monev" class="btn btn-sm btn-neutral">Import DB
                Monev</a>
            <a href="/verifikasi/{{ $tagihan->id }}/payroll/import-excel" class="btn btn-sm btn-neutral">Import Excel</a>
            <a href="/verifikasi/{{ $tagihan->id }}/payroll/cetak" class="btn btn-sm btn-neutral" target="_blank">Cetak</a>
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
                    <td class="border text-center">{{ $loop->iteration }}</td>
                    <td class="border">{{ $item->nama }}</td>
                    <td class="border">{{ $item->norek }}</td>
                    <td class="border">{{ $item->bank }}</td>
                    <td class="border text-right">{{ number_format($item->bruto, 2, ',', '.') }}</td>
                    <td class="border text-right">{{ number_format($item->pajak, 2, ',', '.') }}</td>
                    <td class="border text-right">{{ number_format($item->admin, 2, ',', '.') }}</td>
                    <td class="border text-right">{{ number_format($item->netto, 2, ',', '.') }}</td>
                    <td class="border">
                        <div class="join">
                            <a class="btn btn-xs btn-primary btn-outline join-item"
                                href="/verifikasi/{{ $item->tagihan_id }}/payroll/{{ $item->id }}/edit">Edit</a>
                            <form action="/verifikasi/{{ $item->tagihan_id }}/payroll/{{ $item->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-error btn-outline join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-payroll>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
