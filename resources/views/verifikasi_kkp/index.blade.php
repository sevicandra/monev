@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Verifikasi-kkp</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Tagihan" placeholder="Nomor Tagihan" value="{{ request('search') }}">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-primary-content border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Unit</th>
                    <th class="border border-base-content">PPK</th>
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
                    <tr class="whitespace-nowrap">
                        <td class="text-center border border-base-content">{{ $i }}</td>
                        <td class="border border-base-content">{{ $item->notagihan }}</td>
                        <td class="border border-base-content">{{ indonesiaDate($item->tgltagihan) }}</td>
                        <td class="border border-base-content">{{ optional($item->unit)->namaunit }}</td>
                        <td class="border border-base-content">{{ optional($item->ppk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->dokumen)->namadokumen }}</td>
                        <td class="text-right border border-base-content">Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                        <td class="border border-base-content">
                            <div class="join">
                                <a href="/verifikasi-kkp/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                                <a href="/verifikasi-kkp/{{ $item->id }}/coa"
                                    class="btn btn-xs btn-outline btn-neutral join-item">COA</a>
                                <a href="/verifikasi-kkp/{{ $item->id }}/tolak"
                                    class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menolak data ini?');">Tolak</a>
                                <a href="/verifikasi-kkp/{{ $item->id }}/approve"
                                    class="btn btn-xs btn-outline btn-success join-item"
                                    onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
                            </div>
                        </td>
                    </tr>
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
