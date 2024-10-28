@extends('audit.layouts.index')

@section('content')
    <div></div>
    <div class="w-full overflow-y-auto max-h-full">
        <x-table class="collapse">
            <x-table.header>
                <tr class="align-middle">
                    <x-table.header.column class="border-x text-center">No</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Kode Satker</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Nama Satker</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Pagu</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Realisasi Belanja 51</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Realisasi Belanja 52</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Realisasi Belanja 53</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Jumlah Realisasi</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border  text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border  text-center">{{ $item->kodesatker }}</x-table.body.column>
                        <x-table.body.column class="border ">{{ $item->namasatker }}</x-table.body.column>
                        <x-table.body.column class="border  text-end">
                            {{ number_format($item->pagu->sum('anggaran'), 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border  text-end">
                            {{ number_format($item->realisasi->where('jenis_belanja', '51')->sum('realisasi') - $item->sspb->where('jenis_belanja', '51')->sum('nominal_sspb'), 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border  text-end">
                            {{ number_format($item->realisasi->where('jenis_belanja', '52')->sum('realisasi') - $item->sspb->where('jenis_belanja', '52')->sum('nominal_sspb'), 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border  text-end">
                            {{ number_format($item->realisasi->where('jenis_belanja', '53')->sum('realisasi') - $item->sspb->where('jenis_belanja', '53')->sum('nominal_sspb'), 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border  text-end">
                            {{ number_format($item->realisasi->sum('realisasi') - $item->sspb->sum('nominal_sspb'), 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border ">
                            <a href="/audit/{{ $item->kodesatker }}" class="btn btn-xs btn-primary">Detail</a>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
