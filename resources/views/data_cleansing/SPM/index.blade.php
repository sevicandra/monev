@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Rekap SPM</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="flex gap-2">
            <a href="/cleansing/spm/import" class="btn btn-sm btn-neutral">Import</a>
            <form action="/cleansing/spm/load" method="post" autocomplete="off">
                @csrf
                @method('patch')
                <div class="join">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Load</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <input type="hidden" name="sb" value="{{ request('sb', 'nomor_spm') }}">
                <input type="hidden" name="sd" value="{{ request('sd', 'desc') }}">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor SPM/SP2D">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse">
            <x-table.header>
                <tr class="align-middle">
                    <x-table.header.column class="border-x text-center">No</x-table.header.column>
                    <x-table.header.column class="border-x text-center">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'nomor_spm']) }}">
                                Nomor
                            </a>
                            @if (request('sb', 'nomor_spm') == 'nomor_spm')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'tanggal_spm']) }}">
                                Tanggal
                            </a>
                            @if (request('sb', 'nomor_spm') == 'tanggal_spm')
                                <a href="{{ request()->fullUrlWithQuery(['sb' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'nomor_sp2d']) }}">
                                Nomor SP2D
                            </a>
                            @if (request('sb', 'nomor_spm') == 'nomor_sp2d')
                                <a href="{{ request()->fullUrlWithQuery(['sb' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'tanggal_sp2d']) }}">
                                Tanggal SP2D
                            </a>
                            @if (request('sb', 'nomor_spm') == 'tanggal_sp2d')
                                <a href="{{ request()->fullUrlWithQuery(['sb' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center">Jenis SPM</x-table.header.column>
                    <x-table.header.column class="border-x text-center min-w-[200px]">Deskripsi</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Bruto</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->nomor_spm }}</x-table.body.column>
                        <x-table.body.column
                            class="border text-center whitespace-nowrap">{{ indonesiaDate($item->tanggal_spm) }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->nomor_sp2d }}</x-table.body.column>
                        <x-table.body.column
                            class="border text-center whitespace-nowrap">{{ indonesiaDate($item->tanggal_sp2d) }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->jenis_spm }}</x-table.body.column>
                        <x-table.body.column class="border  min-w-[200px]">{{ $item->deskripsi }}</x-table.body.column>
                        <x-table.body.column class="border text-right">
                            Rp{{ number_format(optional($item->realisasi)->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <span class="join">
                                <a href="/cleansing/spm/{{ $item->id }}/detail" class="btn btn-xs btn-neutral btn-outline join-item">Detail</a>
                                <a href="/cleansing/spm/{{ $item->id }}/edit" class="btn btn-xs btn-neutral btn-outline join-item">Edit</a>
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
