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
            <a href="/bendahara/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-neutral">Sebelumnya</a>
            <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/create"
                class="btn btn-sm btn-neutral">Tambah</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Objek Pajak</th>
                    <th class="border border-base-content">Tarif</th>
                    <th class="border border-base-content">PPh</th>
                    <th class="border border-base-content">DPP</th>
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
                        <td class="border border-base-content">{{ $item->objekpajak->nama }}</td>
                            <td class="border border-base-content">{{ $item->tarif }}%</td>
                            <td class="border border-base-content">{{ number_format(floor($item->pph * ($item->tarif / 100)), 2, ',', '.') }}</td>
                            <td class="border border-base-content">{{ number_format($item->pph, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-center">
                            <div class="join" role="group">
                                <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $item->id }}/edit"
                                    class="btn btn-xs btn-outline btn-neutral join-item">edit</a>
                                <form
                                    action="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $item->id }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-error join-item"
                                        onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
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
