@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPh {{ $rekanan->nama }}</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/monitoring-tagihan/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Objek Pajak</th>
                    <th class="border border-base-content">Tarif</th>
                    <th class="border border-base-content">PPh</th>
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
                        <td class="border border-base-content">{{ optional($item->objekpajak)->nama }}</td>
                            <td class="border border-base-content text-center">{{ $item->tarif }}%</td>
                            <td class="border border-base-content text-right">{{ number_format(floor($item->pph * ($item->tarif / 100)), 2, ',', '.') }}</td>
                            <td class="border border-base-content text-right">{{ number_format($item->pph, 2, ',', '.') }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
