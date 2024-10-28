@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPh {{ $rekanan->nama }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/tagihan-blbi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/create"
                class="btn btn-sm btn-neutral">Tambah</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-rekanan.pph :aksi="true">
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->objekpajak)->nama }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->tarif }}%</x-table.body.column>
                    <x-table.body.column class="border text-right">
                        {{ number_format(floor($item->pph * ($item->tarif / 100)), 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border text-center">
                        <div class="join" role="group">
                            <a href="/tagihan-blbi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $item->id }}/edit"
                                class="btn btn-xs btn-outline btn-neutral join-item">edit</a>
                            <form
                                action="/tagihan-blbi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-rekanan.pph>
    </div>
@endsection
