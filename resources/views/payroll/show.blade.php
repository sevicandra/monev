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
            <a href="/payroll" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/payroll/{{ $tagihan->id }}/cetak" class="btn btn-sm btn-neutral" target="_blank">Cetak</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nama Penerima">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Nama</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor Rekening</x-table.header.column>
                    <x-table.header.column class="border-x">Nama Bank</x-table.header.column>
                    <x-table.header.column class="border-x">Bruto</x-table.header.column>
                    <x-table.header.column class="border-x">Pajak</x-table.header.column>
                    <x-table.header.column class="border-x">Adm.</x-table.header.column>
                    <x-table.header.column class="border-x">Netto</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->norek }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->bank }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->pajak, 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->admin, 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->netto, 2, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
