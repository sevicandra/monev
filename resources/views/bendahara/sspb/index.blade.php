@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">COA</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col lg:flex-row px-4 gap-2 justify-between">
        <div class="lg:basis-5/12 flex gap-2">
            <a href="/bendahara/{{ $tagihan->id }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb/create" class="btn btn-sm btn-neutral">Tambah</a>
        </div>
        <div class="lg:basis-7/12 overflow-hidden max-w-full shrink">
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full max-w-2xl">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal</x-table.header.column>
                    <x-table.header.column class="border-x">NTPN</x-table.header.column>
                    <x-table.header.column class="border-x">Nilai</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="text-center border">{{ $item->tanggal_sspb }}</x-table.body.column>
                        <x-table.body.column class="text-center border">{{ $item->ntpn }}</x-table.body.column>
                        <x-table.body.column class="text-right border">{{ number_format($item->nominal_sspb, 2, ',', '.') }}</x-table.body.column>
                        <x-table.body.column class="border">
                            <div class="join items-center">
                                <a href="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb/{{ $item->id }}" class="btn btn-xs btn-neutral btn-outline join-item">edit</a>
                                <form action="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb/{{ $item->id }}" method="post" onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                    @csrf
                                    @method('Delete')
                                    <button class="btn btn-xs btn-error btn-outline join-item">Hapus</button>
                                </form>
                            </div>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </tbody>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
