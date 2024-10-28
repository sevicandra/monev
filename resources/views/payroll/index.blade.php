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
            <div class="flex gap-1">
                <a href="{{ request()->fullUrlWithQuery(['jns' => '']) }}"
                    class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'ALL' ? 'btn-active' : '' }}">ALL</a>
                <a href="{{ request()->fullUrlWithQuery(['jns' => 'SPBY']) }}"
                    class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'SPBY' ? 'btn-active' : '' }}">SPBY</a>
                <a href="{{ request()->fullUrlWithQuery(['jns' => 'SPP']) }}"
                    class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'SPP' ? 'btn-active' : '' }}">SPP</a>
            </div>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <input type="hidden" name="jns" value="{{ request('jns', 'ALL') }}">
                <input type="hidden" name="sb" value="{{ request('sb', 'nomor_tagihan') }}">
                <input type="hidden" name="sd" value="{{ request('sd', 'desc') }}">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Tagihan">
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
                    <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal</x-table.header.column>
                    <x-table.header.column class="border-x">Unit</x-table.header.column>
                    <x-table.header.column class="border-x">PPK</x-table.header.column>
                    <x-table.header.column class="border-x">Nilai Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Nilai Payroll</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr class="">
                        <x-table.body.column class="border text-center">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
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
                        </x-table.body.column>
                        <x-table.body.column class="border">{{ $item->notagihan }}</x-table.body.column>
                        <x-table.body.column class="border whitespace-nowrap">{{ indonesiaDate($item->tgltagihan) }}</x-table.body.column>
                        <x-table.body.column class="border whitespace-normal">{{ $item->namaunit }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->ppk }}</x-table.body.column>
                        <x-table.body.column class="border text-right">Rp{{ number_format($item->realisasi, 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border text-right">Rp{{ number_format($item->payroll, 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border">
                            <div class="join">
                                <a href="/payroll/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Detail</a>
                                <a href="/payroll/{{ $item->id }}/dokumen"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                                <a href="/payroll/{{ $item->id }}/approve"
                                    class="btn btn-xs btn-outline btn-success join-item"
                                    onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
                            </div>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection