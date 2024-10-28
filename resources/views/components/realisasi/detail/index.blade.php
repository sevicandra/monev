<x-table class="collapse min-w-full">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">Bulan</x-table.header.column>
            <x-table.header.column class="border-x">Realisasi</x-table.header.column>
            <x-table.header.column class="border-x">SSPB</x-table.header.column>
            <x-table.header.column class="border-x">Total</x-table.header.column>
        </tr>
    </x-table.header>
    <tbody>
        {{ $slot }}
    </tbody>
</x-table>