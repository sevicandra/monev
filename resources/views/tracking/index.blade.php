@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tracking</h1>
    </div>
    <div class="">

    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Rekening" value="{{ request('search') }}">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Jenis Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">No Tagihan</x-table.header.column>
                    <x-table.header.column class="border-x">Tahun</x-table.header.column>
                    <x-table.header.column class="border-x">Uraian</x-table.header.column>
                    <x-table.header.column class="border-x">Nama</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor Rekening</x-table.header.column>
                    <x-table.header.column class="border-x">Bank</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <tbody>
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <x-table.body.column class="text-center border">{{ $loop->iteration+ ($data->currentPage() - 1) * $data->perPage() }}</x-table.body.column>
                        <x-table.body.column class="border">
                            @switch($item->tagihan->jnstagihan)
                                @case('0')
                                    SPBy
                                @break

                                @case('1')
                                    SPP
                                @break

                                @case('2')
                                    KKP
                                @break
                            @endswitch
                        </x-table.body.column>
                        <x-table.body.column class="border">{{ $item->tagihan->notagihan }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->tagihan->tahun }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->tagihan->uraian }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->norek }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->bank }}</x-table.body.column>
                        <x-table.body.column class="border">
                            <form action="/tracking" method="post">
                                @csrf
                                <input type="text" name="tagihan_id" value="{{ $item->tagihan->id }}" hidden>
                                <button class="btn btn-xs btn-outline btn-neutral join-item">riwayat</button>
                            </form>
                            {{-- <a href="/tracking/{{ $item->tagihan->id }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">riwayat</a> --}}
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
