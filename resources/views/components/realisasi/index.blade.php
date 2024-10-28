@props(['unit' => true, 'ppk' => true])
<x-table class="collapse w-full">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">Nomor</x-table.header.column>
            @if ($unit)
                <x-table.header.column class="border-x">Unit</x-table.header.column>
            @endif
            @if ($ppk)
                <x-table.header.column class="border-x">PPK</x-table.header.column>
            @endif
            <x-table.header.column class="border-x">Pagu</x-table.header.column>
            <x-table.header.column class="border-x">Realisasi</x-table.header.column>
            <x-table.header.column class="border-x">Pengembalian</x-table.header.column>
            <x-table.header.column class="border-x">Sisa Pagu</x-table.header.column>
            <x-table.header.column class="border-x">Persentase</x-table.header.column>
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>
