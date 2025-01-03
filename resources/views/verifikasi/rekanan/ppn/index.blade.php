@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">PPN {{ $rekanan->nama }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/verifikasi/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/create"
                class="btn btn-sm btn-neutral">Tambah</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-rekanan.ppn>
            @foreach ($data as $item)
                <tr>
                    <td class="border text-center">{{ $loop->iteration }}</td>
                    <td class="border">{{ $item->nomorfaktur }}</td>
                    <td class="border">{{ indonesiaDate($item->tanggalfaktur) }}</td>
                    <td class="border">{{ $item->tarif * 100 }}%</td>
                    <td class="border text-right">
                        {{ number_format(floor($item->ppn * $item->tarif), 2, ',', '.') }}</td>
                    <td class="border text-right">{{ number_format($item->ppn, 2, ',', '.') }}</td>
                    <td class="border">
                        <div class="join">
                            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/{{ $item->id }}/edit"
                                class="btn btn-xs btn-outline btn-neutral join-item">edit</a>
                            <form
                                action="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-outline btn-error join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-rekanan.ppn>
    </div>
@endsection
