@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">DNP Perjadin</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="{{ $base_url }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/create" class="btn btn-sm btn-neutral">Tambah</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/import" class="btn btn-sm btn-neutral">Import</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/cetak" target="_blank"
                class="btn btn-sm btn-neutral">Cetak</a>
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/create-payroll"
                class="btn btn-sm btn-neutral">Generate Payroll</a>
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nama/NIP">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-dnp.perjadin>
            @foreach ($data as $item)
                @php
                    $a = collect(json_decode($item->transport))->sum('nilai');
                    $b = collect(json_decode($item->transportLain))->sum('nilai');
                    $c = 0;
                    $d = 0;
                    $e = 0;
                @endphp

                @foreach (collect(json_decode($item->uangharian)) as $uangharian)
                    @php
                        $c += $uangharian->frekuensi * $uangharian->nilai;
                    @endphp
                @endforeach

                @foreach (collect(json_decode($item->penginapan)) as $penginapan)
                    @php
                        $d += $penginapan->frekuensi * $penginapan->nilai;
                    @endphp
                @endforeach

                @foreach (collect(json_decode($item->representatif)) as $representatif)
                    @php
                        $e += $representatif->frekuensi * $representatif->nilai;
                    @endphp
                @endforeach
                <tr>
                    <x-table.body.column class="border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->nip }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->nip }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->st }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->lokasi }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->durasi }}</x-table.body.column>
                    <x-table.body.column class="border">Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.') }}
                    </x-table.body.column>
                    <x-table.body.column class="border">{{ $item->bank }} {{ $item->norek }} <br> a.n.
                        {{ $item->namarek }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <div class="join">
                            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/{{ $item->id }}/edit"
                                class="btn btn-xs btn-outline btn-neutral join-item">Edit</a>
                            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/{{ $item->id }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">Detail</a>
                            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/{{ $item->id }}/cetak"
                                class="btn btn-xs btn-outline btn-neutral join-item" target="_blank">Cetak</a>
                            <form action="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin/{{ $item->id }}"
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
        </x-dnp.perjadin>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
