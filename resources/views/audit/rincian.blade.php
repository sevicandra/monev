@extends('audit.layouts.index')

@section('content')
    <div class="flex justify-between px-2">
        <div>
            <a href="/audit/{{ $kdSatker }}" class="btn btn-sm btn-neutral btn-outline">Kembali</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                <input type="hidden" name="sb" value="{{ request('sb', 'nomor_tagihan') }}">
                <input type="hidden" name="sd" value="{{ request('sd', 'desc') }}">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor tagihan/Uraian">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="w-full overflow-y-auto max-h-full">
        <x-table class="collapse">
            <x-table.header>
                <tr>
                    <x-table.header.column class="border-x text-center ">No</x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            Jenis Tagihan
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sb' => 'nomor_tagihan']) }}">
                                Nomor Tagihan
                            </a>
                            @if (request('sb', 'nomor_tagihan') == 'nomor_tagihan')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sb' => 'tanggal_tagihan']) }}">
                                Tanggal Tagihan
                            </a>
                            @if (request('sb', 'nomor_tagihan') == 'tanggal_tagihan')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        Uraian
                    </x-table.header.column>
                    <x-table.header.column
                        class="border-x text-center ">Realisasi</x-table.header.column>
                    <x-table.header.column class="border-x text-center ">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column
                            class="border  text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border  text-center">
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
                        <x-table.body.column class="border  text-center">
                            {{ $item->notagihan }}</x-table.body.column>
                        <x-table.body.column class="border  text-center">
                            {{ Date::parse($item->tgltagihan)->format('d-M-Y') }}</x-table.body.column>
                        <x-table.body.column class="border  text-justify max-w-md">
                            {{ $item->uraian }}</x-table.body.column>
                        <x-table.body.column class="border  text-right">
                            {{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border  text-center">
                            <span class="flex gap-1 justify-center">
                                <a href="/audit/{{ $item->id }}/coa" class="btn btn-xs btn-primary">COA</a>
                                <a href="/audit/{{ $item->id }}/dokumen" class="btn btn-xs btn-primary">Dokumen</a>

                            </span>
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
