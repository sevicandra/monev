<x-table class="collapse min-w-full">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">Nomor</x-table.header.column>
            <x-table.header.column class="border-x">POK</x-table.header.column>
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