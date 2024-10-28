@props(['aksi' => true])
<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border">No</x-table.header.column>
            <x-table.header.column class="border">Nomor Faktur</x-table.header.column>
            <x-table.header.column class="border">Tanggal Faktur</x-table.header.column>
            <x-table.header.column class="border">Tarif</x-table.header.column>
            <x-table.header.column class="border">PPN</x-table.header.column>
            <x-table.header.column class="border">NOP</x-table.header.column>
            @if ($aksi)
                <x-table.header.column class="border">Aksi</x-table.header.column>
            @endif
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>
