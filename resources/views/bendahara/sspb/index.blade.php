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
        <table class="table border-collapse w-full max-w-2xl">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Nilai</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center border border-base-content">{{ $i }}</td>
                        <td class="text-center border border-base-content">{{ $item->tanggal_sspb }}</td>
                        <td class="text-center border border-base-content">{{ number_format($item->nominal_sspb, 2, ',', '.') }}</td>
                        <td class="border border-base-content">
                            <div class="join items-center">
                                <a href="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb/{{ $item->id }}" class="btn btn-xs btn-neutral btn-outline join-item">edit</a>
                                <form action="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb/{{ $item->id }}" method="post" onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                    @csrf
                                    @method('Delete')
                                    <button class="btn btn-xs btn-error btn-outline join-item">Hapus</button>
                                </form>
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
