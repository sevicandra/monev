<x-table class="collapse min-w-full">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">Nomor</x-table.header.column>
            <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
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

            <x-table.header.column class="border-x">POK</x-table.header.column>
            <x-table.header.column class="border-x">Realisasi</x-table.header.column>
            <x-table.header.column class="border-x">SSPB</x-table.header.column>
            <x-table.header.column class="border-x">Tanggal SP2D</x-table.header.column>
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>
