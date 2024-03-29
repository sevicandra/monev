@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tagihan</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/tagihan/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Tagihan">
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
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Uraian</th>
                    <th class="border border-base-content">PIC</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Unit</th>
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
                    <tr class="whitespace-nowrap @if ($item->catatan) text-error @endif">
                        <td class="border border-base-content text-center"
                            @if ($item->catatan) rowspan="2" @endif>{{ $i }}</td>
                        <td class="border border-base-content">
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
                        <td class="border border-base-content" style="white-space:normal; min-width:300px">
                            {{ $item->uraian }}</td>
                        <td class="border border-base-content">{{ optional($item->stafPpk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->ppk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->unit)->namaunit }}</td>
                        <td class="border border-base-content">{{ optional($item->dokumen)->namadokumen }}</td>
                        <td class="border border-base-content text-right">
                            Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                        <td class="border border-base-content" @if ($item->catatan) rowspan="2" @endif>
                            <div class="join">
                                <a href="/tagihan/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-neutral btn-outline join-item">Ubah</a>
                                <a href="/tagihan/{{ $item->id }}/realisasi"
                                    class="btn btn-xs btn-neutral btn-outline join-item">Realisasi</a>
                                {{-- @if ($item->dokumen->statusdnp === '1')
                                        <a href="/tagihan/{{ $item->id }}/dnp" class="btn btn-xs btn-neutral btn-outline join-item">DNP</a>
                                        @endif --}}
                                @if ($item->dokumen->dnp_perjadin)
                                    <a href="/tagihan/{{ $item->id }}/dnp-perjadin"
                                        class="btn btn-xs btn-neutral btn-outline join-item">DNP Perjadin</a>
                                @endif
                                @if ($item->dokumen->dnp_honor)
                                    <a href="/tagihan/{{ $item->id }}/dnp-honorarium"
                                        class="btn btn-xs btn-neutral btn-outline join-item">DNP Honor</a>
                                @endif
                                @if ($item->dokumen->statusrekanan === '1')
                                    <a href="/tagihan/{{ $item->id }}/rekanan"
                                        class="btn btn-xs btn-neutral btn-outline join-item">Rekanan</a>
                                @endif
                                <a href="/tagihan/{{ $item->id }}/upload"
                                    class="btn btn-xs btn-neutral btn-outline join-item">Upload</a>
                                <a href="/tagihan/{{ $item->id }}/payroll"
                                    class="btn btn-xs btn-neutral btn-outline join-item">Payroll</a>
                                <form action="/tagihan/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-error btn-outline join-item"
                                        onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                                </form>
                                <form action="/tagihan/{{ $item->id }}/kirim" method="post">
                                    @csrf
                                    <button class="btn btn-xs btn-success btn-outline join-item"
                                        onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Kirim</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if ($item->catatan)
                        <tr>
                            <td colspan="9" class="border border-base-content text-error py-0 border-dashed">
                                Catatan: {{ $item->catatan }}
                            </td>
                        </tr>
                    @endif
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
