<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">No</x-table.header.column>
            <x-table.header.column class="border-x">Tanggal</x-table.header.column>
            <x-table.header.column class="border-x">Nama</x-table.header.column>
            <x-table.header.column class="border-x">Action</x-table.header.column>
            <x-table.header.column class="border-x">Keterangan</x-table.header.column>
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>