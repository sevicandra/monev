@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPN {{ $rekanan->nama }}</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/monitoring-tagihan/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-rekanan.ppn :aksi="FALSE">
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column
                        class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ $item->nomorfaktur }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ indonesiaDate($item->tanggalfaktur) }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ $item->tarif * 100 }}%</x-table.body.column>
                    <x-table.body.column
                        class="border text-right">{{ number_format(floor($item->ppn * $item->tarif), 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-right">{{ number_format($item->ppn, 2, ',', '.') }}</x-table.body.column>
                </tr>
            @endforeach
        </x-rekanan.ppn>
    </div>
@endsection
