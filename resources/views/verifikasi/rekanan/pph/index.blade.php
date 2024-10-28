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
            <a href="/verifikasi/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/create"
                class="btn btn-sm btn-neutral">Tambah</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-rekanan.pph :aksi="true">
            @foreach ($data as $item)
                <tr>
                    <td class="border text-center">{{ $loop->iteration }}</td>
                    <td class="border">{{ optional($item->objekpajak)->nama }}</td>
                    <td class="border">{{ $item->tarif }}%</td>
                    <td class="border">
                        {{ number_format(floor($item->pph * ($item->tarif / 100)), 2, ',', '.') }}</td>
                    <td class="border">{{ number_format($item->pph, 2, ',', '.') }}</td>
                    <td class="border text-center">
                        <div class="join" role="group">
                            <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $item->id }}/edit"
                                class="btn btn-xs btn-outline btn-neutral join-item">edit</a>
                            <form
                                action="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $item->id }}"
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
        </x-rekanan.pph>
    </div>
@endsection
