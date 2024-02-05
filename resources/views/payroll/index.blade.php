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
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="nomor SPP/SPBy">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
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
                    <th class="border border-base-content">Unit</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Nilai Tagihan</th>
                    <th class="border border-base-content">Nilai Payroll</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr class="">
                        <td class="border border-base-content text-center">{{ $i++ }}</td>
                        <td class="border border-base-content text-center">
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
                        <td class="border border-base-content whitespace-nowrap">{{ indonesiaDate($item->tgltagihan) }}</td>
                        <td class="border border-base-content whitespace-normal">{{ $item->namaunit }}</td>
                        <td class="border border-base-content">{{ $item->ppk }}</td>
                        <td class="border border-base-content text-right">Rp{{ number_format($item->realisasi, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">Rp{{ number_format($item->payroll, 2, ',', '.') }}</td>
                        <td class="border border-base-content">
                            <div class="join">
                                <a href="/payroll/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Detail</a>
                                <a href="/payroll/{{ $item->id }}/dokumen"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                                <a href="/payroll/{{ $item->id }}/approve"
                                    class="btn btn-xs btn-outline btn-success join-item"
                                    onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
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