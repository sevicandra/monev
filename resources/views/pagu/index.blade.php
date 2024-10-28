@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Pagu</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="lg:basis-5/12 flex gap-2 shrink max-w-full">
            <a href="/pagu/create" class="btn btn-sm btn-neutral">Tambah Data</a>
            <a href="/pagu/import" class="btn btn-sm btn-neutral">Impor Data</a>
            <a href="/pagu/mass-update" class="btn btn-sm btn-neutral">Update</a>
        </div>
        <div class="lg:basis-7/12 overflow-hidden max-w-full shrink">
            <form action="" method="get" autocomplete="off">
                <div class="join flex max-w-full justify-end">
                    <input type="text" name="program" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('program') }}" placeholder="Program">
                    <input type="text" name="kegiatan" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('kegiatan') }}" placeholder="Kegiatan">
                    <input type="text" name="kro" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('kro') }}" placeholder="KRO">
                    <input type="text" name="ro" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('ro') }}" placeholder="RO">
                    <input type="text" name="komponen" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('komponen') }}" placeholder="Komponen">
                    <input type="text" name="subkomponen" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('subkomponen') }}" placeholder="Subkomponen">
                    <input type="text" name="akun" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('akun') }}" placeholder="Akun">
                    <button class="btn btn-sm btn-neutral join-item" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-coa :realisasi="FALSE" :pengembalian="FALSE" :unit="TRUE" :sisa="FALSE">
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->program }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->kegiatan }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->kro }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->ro }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->komponen }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->subkomponen }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->akun }}</x-table.body.column>
                    <x-table.body.column class="border text-right">Rp{{ number_format($item->anggaran, 2, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        @if ($item->unit)
                            {{ $item->unit->namaunit }}
                        @endif
                    </x-table.body.column>
                    <x-table.body.column class="border text-center">
                        <div class="join">
                            <a href="/pagu/{{ $item->id }}/edit"
                                class="btn btn-xs btn-outline btn-neutral join-item">Ubah</a>
                            <form action="/pagu/{{ $item->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-coa>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
