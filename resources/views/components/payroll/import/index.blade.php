<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">No</x-table.header.column>
            <x-table.header.column class="border-x">Nama Pemilik Rekening</x-table.header.column>
            <x-table.header.column class="border-x">Nomor Rekening</x-table.header.column>
            <x-table.header.column class="border-x">Nama Bank</x-table.header.column>
            <x-table.header.column class="border-x">Aksi</x-table.header.column>
        </tr>
    </x-table.header>
    <tbody>
        {{ $slot }}
    </tbody>
</x-table>
