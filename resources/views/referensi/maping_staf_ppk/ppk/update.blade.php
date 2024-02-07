@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Staf PPk {{ $stafppk->nama }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/maping-staf-ppk/{{ $stafppk->id }}/ppk" class="btn btn-sm btn-neutral"> Kembali</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        value="{{ request('search') }}" placeholder="Nama/NIP">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">NIP</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp

                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content text-center">{{ $item->nama }}</td>
                        <td class="border border-base-content text-center">{{ $item->nip }}</td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <a href="/maping-staf-ppk/{{ $stafppk->id }}/ppk/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral">Pilih</a>
                            </div>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection