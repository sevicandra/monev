<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">No</x-table.header.column>
            <x-table.header.column class="border-x">Nama</x-table.header.column>
            <x-table.header.column class="border-x">NIP/NIK/NRP/DLL</x-table.header.column>
            <x-table.header.column class="border-x">Unit Kerja</x-table.header.column>
            <x-table.header.column class="border-x">ST</x-table.header.column>
            <x-table.header.column class="border-x">Lokasi</x-table.header.column>
            <x-table.header.column class="border-x">Durasi</x-table.header.column>
            <x-table.header.column class="border-x">Netto</x-table.header.column>
            <x-table.header.column class="border-x">Rekening</x-table.header.column>
            <x-table.header.column class="border-x">Aksi</x-table.header.column>
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>