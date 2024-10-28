@extends('audit.layouts.index')

@section('content')
    <div class="flex justify-between px-2">
        <div>
            <a href="/audit/{{ $tagihan->kodesatker }}/{{ $spm->nomor_sp2d }}"
                class="btn btn-sm btn-neutral btn-outline">Kembali</a>
        </div>
        <div>
        </div>
    </div>
    <div class="w-full overflow-y-auto max-h-full">
        <x-table class="collapse">
            <x-table.header>
                <tr>
                    <x-table.header.column class="border-x text-center">No</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Program</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Kegiatan</x-table.header.column>
                    <x-table.header.column class="border-x text-center">KRO</x-table.header.column>
                    <x-table.header.column class="border-x text-center">RO</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Komponen</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Subkomponen</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Akun</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Realisasi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border  text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->pagu->program }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->pagu->kegiatan }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->pagu->kro }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->pagu->ro }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->pagu->komponen }}</x-table.body.column>
                        <x-table.body.column
                            class="border text-center">{{ $item->pagu->subkomponen }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->pagu->akun }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->realisasi, 2, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection

@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
