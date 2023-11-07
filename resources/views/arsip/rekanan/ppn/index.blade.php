@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPN {{ $rekanan->nama }}</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/arsip/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Nomor Faktur</th>
                    <th class="border border-base-content">Tanggal Faktur</th>
                    <th class="border border-base-content">Tarif</th>
                    <th class="border border-base-content">PPN</th>
                    <th class="border border-base-content">NOP</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center border border-base-content">{{ $i }}</td>
                        <td class="border border-base-content text-center">{{ $item->nomorfaktur }}</td>
                        <td class="border border-base-content text-center">{{ indonesiaDate($item->tanggalfaktur) }}</td>
                        <td class="border border-base-content text-center">{{ $item->tarif * 100 }}%</td>
                        <td class="border border-base-content text-right">{{ number_format(floor($item->ppn * $item->tarif), 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->ppn, 2, ',', '.') }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
