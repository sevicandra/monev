@props(['realisasi' => true, 'anggaran' => true, 'aksi' => true, 'pengembalian' => true, 'sisa'=>true, 'unit'=>false])
<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            <x-table.header.column class="border-x">No</x-table.header.column>
            <x-table.header.column class="border-x">Program</x-table.header.column>
            <x-table.header.column class="border-x">Kegiatan</x-table.header.column>
            <x-table.header.column class="border-x">KRO</x-table.header.column>
            <x-table.header.column class="border-x">RO</x-table.header.column>
            <x-table.header.column class="border-x">Komponen</x-table.header.column>
            <x-table.header.column class="border-x">Subkomponen</x-table.header.column>
            <x-table.header.column class="border-x">Akun</x-table.header.column>
            @if ($anggaran)
                <x-table.header.column class="border-x">Anggaran</x-table.header.column>
            @endif
            @if ($realisasi)
                <x-table.header.column class="border-x">Realisasi</x-table.header.column>
            @endif
            @if ($pengembalian)
                <x-table.header.column class="border-x">Pengembalian</x-table.header.column>
            @endif
            @if ($sisa)
                <x-table.header.column class="border-x">Sisa Anggaran</x-table.header.column>
            @endif
            @if ($unit)
                <x-table.header.column class="border-x">Unit</x-table.header.column>
            @endif
            @if ($aksi)
                <x-table.header.column class="border-x">Aksi</x-table.header.column>
            @endif
        </tr>
    </x-table.header>
    <x-table.body>
        {{ $slot }}
    </x-table.body>
</x-table>
