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
        <table class="table border-primary-content border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">No Tagihan</th>
                    <th class="border border-base-content">Tahun</th>
                    <th class="border border-base-content">Uraian</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">Nomor Rekening</th>
                    <th class="border border-base-content">Bank</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1 + ($data->currentPage() - 1) * $data->perPage();
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <td class="text-center border border-base-content">{{ $i++ }}</td>
                        <td class="border border-base-content">
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
                        </td>
                        <td class="border border-base-content">{{ $item->tagihan->notagihan }}</td>
                        <td class="border border-base-content">{{ $item->tagihan->tahun }}</td>
                        <td class="border border-base-content">{{ $item->tagihan->uraian }}</td>
                        <td class="border border-base-content">{{ $item->nama }}</td>
                        <td class="border border-base-content">{{ $item->norek }}</td>
                        <td class="border border-base-content">{{ $item->bank }}</td>
                        </td>
                        <td class="border border-base-content">
                            <form action="/tracking" method="post">
                                @csrf
                                <input type="text" name="tagihan_id" value="{{ $item->tagihan->id }}" hidden>
                                <button class="btn btn-xs btn-outline btn-neutral join-item">riwayat</button>
                            </form>
                            {{-- <a href="/tracking/{{ $item->tagihan->id }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">riwayat</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
