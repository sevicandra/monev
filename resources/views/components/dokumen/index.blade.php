@props([
    'no' => true,
    'berkas' => true,
    'extensi' => true,
    'keterangan' => true,
    'tanggal' => true,
    'file' => true,
    'aksi' => true,
])
<x-table class="collapse">
    <x-table.header>
        <tr class="text-center">
            @if ($no)
                <x-table.header.column class="border-x">No</x-table.header.column>
            @endif
            @if ($berkas)
                <x-table.header.column class="border-x">Berkas</x-table.header.column>
            @endif
            @if ($extensi)
                <x-table.header.column class="border-x">Extensi File</x-table.header.column>
            @endif
            @if ($keterangan)
                <x-table.header.column class="border-x">Keterangan</x-table.header.column>
            @endif
            @if ($tanggal)
                <x-table.header.column class="border-x">Tanggal</x-table.header.column>
            @endif
            @if ($file)
                <x-table.header.column class="border-x">File</x-table.header.column>
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
