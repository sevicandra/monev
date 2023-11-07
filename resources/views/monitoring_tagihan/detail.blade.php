@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Riwayat</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/monitoring-tagihan" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">Action</th>
                    <th class="border border-base-content">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content">{{ indonesiaDate($item->created_at) }}</td>
                        <td class="border border-base-content">{{ $item->User }}</td>
                        <td class="border border-base-content text-center">{{ $item->action }}</td>
                        <td class="border border-base-content text-center">{{ $item->catatan }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
