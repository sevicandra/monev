@props(['aksi' => true])
<x-table class="collapse">
    <x-table.header class="text-center">
        <tr class="text-center">
            <x-table.header.column class="border-x">No</x-table.header.column>
            <x-table.header.column class="border-x">Nama</x-table.header.column>
            <x-table.header.column class="border-x">NIP/NIK/NRP/DLL</x-table.header.column>
            <x-table.header.column class="border-x">Dasar Penugasan</x-table.header.column>
            <x-table.header.column class="border-x">Jabatan</x-table.header.column>
            <x-table.header.column class="border-x">Golongan</x-table.header.column>
            <x-table.header.column class="border-x">NPWP</x-table.header.column>
            <x-table.header.column class="border-x">Frekuensi</x-table.header.column>
            <x-table.header.column class="border-x">Nilai Satuan</x-table.header.column>
            <x-table.header.column class="border-x">Bruto</x-table.header.column>
            <x-table.header.column class="border-x">Pajak</x-table.header.column>
            <x-table.header.column class="border-x">Netto</x-table.header.column>
            <x-table.header.column class="border-x">Rekening</x-table.header.column>
            @if ($aksi)
                <x-table.header.column class="border-x">Aksi</x-table.header.column>
            @endif
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>
