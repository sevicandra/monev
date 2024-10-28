@extends('audit.layouts.index')

@section('content')
    <div class="flex justify-between px-2">
        <div>
            <a href="/audit/{{ $tagihan->kodesatker }}/{{ $spm->nomor_sp2d }}"
                class="btn btn-sm btn-neutral btn-outline">Kembali</a>
        </div>
        <div>
        </div>
    </div>
    <div class="w-full overflow-y-auto max-h-full">
        <x-table class="collapse">
            <x-table.header>
                <tr>
                    <x-table.header.column class="border-x text-center">No</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Jenis Dokumen</x-table.header.column>
                    <x-table.header.column class="border-x text-center">extensi file</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Keterangan</x-table.header.column>
                    <x-table.header.column class="border-x text-center">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border  text-center">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column
                            class="border text-center">{{ optional($item->berkas)->namaberkas }}</x-table.body.column>
                        <x-table.body.column
                            class="border text-center">{{ explode('.', $item->file)[1] }}</x-table.body.column>
                        <x-table.body.column class="border text-center">{{ $item->uraian }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <a href="/file-view/{{ $item->file }}" class="btn btn-xs btn-outline btn-neutral"
                                target="_blank">Preview File</a>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
@endsection

@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
