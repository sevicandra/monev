@props([
    'no' => true,
    'jenis' => true,
    'nomor' => true,
    'uraian' => true,
    'tanggal' => true,
    'tanggal_spm' => true,
    'nomor_spm' => true,
    'nomor_sp2d' => true,
    'tanggal_sp2d' => true,
    'unit' => true,
    'ppk' => true,
    'pic' => true,
    'dokumen' => true,
    'bruto' => true,
    'status' => true,
    'aksi' => true,
    'update' => true,
])

<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            @if ($no)
                <x-table.header.column class="border-x">No</x-table.header.column>
            @endif
            @if ($jenis)
                <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
            @endif
            @if ($nomor)
                <x-table.header.column class="border-x">
                    <span class="flex items-center justify-center gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['sb' => 'nomor_tagihan']) }}">
                            Nomor
                        </a>
                        @if (request('sb', 'nomor_tagihan') == 'nomor_tagihan')
                            <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                class="btn btn-xs btn-ghost p-0 ">
                                {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                            </a>
                        @endif
                    </span>
                </x-table.header.column>
            @endif
            @if ($tanggal)
                <x-table.header.column class="border-x">
                    <span class="flex items-center justify-center gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['sb' => 'tanggal_tagihan']) }}">
                            Tanggal
                        </a>
                        @if (request('sb', 'nomor_tagihan') == 'tanggal_tagihan')
                            <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                class="btn btn-xs btn-ghost p-0 ">
                                {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                            </a>
                        @endif
                    </span>
                </x-table.header.column>
            @endif
            @if ($uraian)
                <x-table.header.column class="border-x min-w-[300px]">
                    Uraian
                </x-table.header.column>
            @endif
            @if ($nomor_spm)
                <x-table.header.column class="border-x">
                    Nomor SPM
                </x-table.header.column>
            @endif
            @if ($tanggal_spm)
                <x-table.header.column class="border-x">
                    Tanggal SPM
                </x-table.header.column>
            @endif
            @if ($nomor_sp2d)
                <x-table.header.column class="border-x">
                    Nomor SP2D
                </x-table.header.column>
            @endif
            @if ($tanggal_sp2d)
                <x-table.header.column class="border-x">
                    Tanggal SP2D
                </x-table.header.column>
            @endif
            @if ($unit)
                <x-table.header.column class="border-x">Unit</x-table.header.column>
            @endif
            @if ($ppk)
                <x-table.header.column class="border-x">PPK</x-table.header.column>
            @endif
            @if ($pic)
                <x-table.header.column class="border-x">PIC</x-table.header.column>
            @endif
            @if ($dokumen)
                <x-table.header.column class="border-x">Jenis Dokumen</x-table.header.column>
            @endif
            @if ($bruto)
                <x-table.header.column class="border-x">Bruto</x-table.header.column>
            @endif
            @if ($status)
                <x-table.header.column class="border-x">Status</x-table.header.column>
            @endif
            @if ($update)
                <x-table.header.column class="border-x">
                    <span class="flex items-center justify-center gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['sb' => 'updated']) }}">
                            Update
                        </a>
                        @if (request('sb', 'nomor_tagihan') == 'updated')
                            <a href="{{ request()->fullUrlWithQuery(['sd' => request('sd', 'desc') == 'desc' ? 'asc' : 'desc']) }}"
                                class="btn btn-xs btn-ghost p-0 ">
                                {{ request('sd', 'desc') == 'desc' ? '▲' : '▼' }}
                            </a>
                        @endif
                    </span>
                </x-table.header.column>
            @endif
            @if ($aksi)
                <x-table.header.column class="border-x">Aksi</x-table.header.column>
            @endif
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>
