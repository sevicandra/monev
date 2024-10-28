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
            <a href="/verifikasi" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/verifikasi/{{ $tagihan->id }}/coa/create" class="btn btn-sm btn-neutral">Tambah</a>
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
                    <button class="btn btn-sm btn-outline join-item" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-coa
            :anggaran="false"
            :pengembalian="false"
            :sisa="false"
        >
            @foreach ($data as $item)
                <tr>
                    <td class="text-center border">{{ $loop->iteration }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->program }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->kegiatan }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->kro }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->ro }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->komponen }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->subkomponen }}</td>
                    <td class="border text-center">{{ optional($item->pagu)->akun }}</td>
                    <td class="text-right border">{{ number_format($item->realisasi, 2, ',', '.') }}
                    </td>
                    <td class="text-center border">
                        <div class="join">
                            <a href="/verifikasi/{{ $tagihan->id }}/coa/{{ $item->id }}/edit"
                                class="btn btn-xs btn-primary join-item">Edit</a>
                            <form action="/verifikasi/{{ $tagihan->id }}/coa/{{ $item->id }}" method="post"
                                onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-error join-item">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-coa>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
