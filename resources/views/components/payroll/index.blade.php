@props(['aksi' => TRUE])
<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">No</x-table.header.column>
            <x-table.header.column class="border-x">Nama</x-table.header.column>
            <x-table.header.column class="border-x">Nomor Rekening</x-table.header.column>
            <x-table.header.column class="border-x">Nama Bank</x-table.header.column>
            <x-table.header.column class="border-x">Bruto</x-table.header.column>
            <x-table.header.column class="border-x">Pajak</x-table.header.column>
            <x-table.header.column class="border-x">Adm.</x-table.header.column>
            <x-table.header.column class="border-x">Netto</x-table.header.column>
            @if ($aksi)
            <x-table.header.column class="border-x">Aksi</x-table.header.column>
            @endif
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>