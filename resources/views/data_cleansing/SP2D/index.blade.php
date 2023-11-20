@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">SP2D Duplikat</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">

        </div>
        <div class="">

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Nomor SP2D</th>
                    <th class="border border-base-content">Tanggal SP2D</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=1;
                @endphp
                @foreach ($data as $item)
                    <tr class="text-center">
                        <td class="border border-base-content">{{ $i++ }}</td>
                        <td class="border border-base-content">
                            @switch($item->jnstagihan)
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
                        <td class="border border-base-content">{{ $item->notagihan }}</td>
                        <td class="border border-base-content">{{ indonesiaDate($item->tgltagihan) }}</td>
                        <td class="border border-base-content">{{ $item->nomor_sp2d }}</td>
                        <td class="border border-base-content">{{ indonesiaDate($item->tanggal_sp2d) }}</td>
                        <td class="border border-base-content">
                            <form action="/cleansing/sp2d/{{ $item->id }}" method="post" onsubmit="return confirm('Apakah anda yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-error btn-outline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection