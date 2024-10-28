@extends('audit.layouts.index')

@section('content')
    <div class="flex justify-between px-2">
        <div>
            <a href="/audit" class="btn btn-sm btn-neutral btn-outline">Kembali</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
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
    <div class="w-full overflow-y-auto max-h-full">
        <x-table class="collapse">
            <x-table.header>
                <tr>
                    <x-table.header.column class="border-x text-center ">No</x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'nomor_spm']) }}">
                                Nomor SPM
                            </a>
                            @if (request('sb', 'nomor_spm') == 'nomor_spm')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'tanggal_spm']) }}">
                                Tanggal SPM
                            </a>
                            @if (request('sb', 'nomor_spm') == 'tanggal_spm')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'nomor_sp2d']) }}">
                                Nomor SP2D
                            </a>
                            @if (request('sb', 'nomor_spm') == 'nomor_sp2d')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        <span class="flex items-center justify-center gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sb' => 'tanggal_sp2d']) }}">
                                Tanggal SP2D
                            </a>
                            @if (request('sb', 'nomor_spm') == 'tanggal_sp2d')
                                <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                    class="btn btn-xs btn-ghost p-0 ">
                                    {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                                </a>
                            @endif
                        </span>
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">
                        Jenis SPM
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center min-w-[200px]">
                        Deskripsi
                    </x-table.header.column>
                    <x-table.header.column class="border-x text-center ">Realisasi</x-table.header.column>
                    <x-table.header.column class="border-x text-center ">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->nomor_spm }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            {{ Date::parse($item->tanggal_spm)->format('d-M-Y') }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->nomor_sp2d }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            {{ Date::parse($item->tanggal_sp2d)->format('d-M-Y') }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            {{ $item->jenis_spm }}
                        </x-table.body.column>
                        <x-table.body.column class="border min-w-[200px]">
                            {{ $item->deskripsi }}
                        </x-table.body.column>
                        <x-table.body.column class="border text-right">
                            {{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <a href="/audit/{{ $item->kd_satker }}/{{ $item->nomor_sp2d }}"
                                class="btn btn-xs btn-primary">Detail</a>
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
