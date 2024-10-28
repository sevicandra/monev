
<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border">No</x-table.header.column>
            <x-table.header.column class="border">Nama</x-table.header.column>
            <x-table.header.column class="border">NPWP</x-table.header.column>
            <x-table.header.column class="border">Id Pajak</x-table.header.column>
            <x-table.header.column class="border">Aksi</x-table.header.column>
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>