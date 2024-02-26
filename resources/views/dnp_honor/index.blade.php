@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="h2">DNP Honorarium</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="{{ $base_url }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/create" class="btn btn-sm btn-neutral">Tambah</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/import" class="btn btn-sm btn-neutral">Import</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/cetak" target="_blank" class="btn btn-sm btn-neutral">Cetak</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium/create-payroll" class="btn btn-sm btn-neutral">Generate Payroll</a>
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
        <table class="table border-collapse w-full whitespace-nowrap">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">NIP/NIK/NRP/DLL</th>
                    <th class="border border-base-content">Dasar Penugasan</th>
                    <th class="border border-base-content">Jabatan</th>
                    <th class="border border-base-content">Golongan</th>
                    <th class="border border-base-content">NPWP</th>
                    <th class="border border-base-content">Frekuensi</th>
                    <th class="border border-base-content">Nilai Satuan</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Pajak</th>
                    <th class="border border-base-content">Netto</th>
                    <th class="border border-base-content">Rekening</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content">{{ $no++ }}</td>
                        <td class="border border-base-content">{{ $item->nama }}</td>
                        <td class="border border-base-content">{{ $item->nip }}</td>
                        <td class="border border-base-content">{{ $item->dasar }}</td>
                        <td class="border border-base-content">{{ $item->jabatan }}</td>
                        <td class="border border-base-content">{{ $item->gol }}</td>
                        <td class="border border-base-content">{{ $item->npwp }}</td>
                        <td class="border border-base-content">{{ $item->frekuensi }}</td>
                        <td class="border border-base-content">{{ number_format($item->nilai, 0, ',', '.') }}</td>
                        <td class="border border-base-content">{{ number_format($item->bruto, 0, ',', '.') }}</td>
                        <td class="border border-base-content">{{ number_format($item->pajak, 0, ',', '.') }}</td>
                        <td class="border border-base-content">{{ number_format($item->netto, 0, ',', '.') }}</td>
                        <td class="border border-base-content">{{ $item->bank }} {{ $item->norek }} <br> a.n.
                            {{ $item->namarek }}</td>
                        <td class="border border-base-content">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('pagination')

@endsection
