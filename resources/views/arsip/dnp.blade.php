@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">DNP</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/arsip" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
            </div>
            <div class="col-lg-5">
                <form action="" method="get" autocomplete="off">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="search">
                        <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <x-table class="collapse">
                        <x-table.header>
                            <tr class="text-center">
                                <x-table.header.column class="border-x">No</x-table.header.column>
                                <x-table.header.column class="border-x">NIP</x-table.header.column>
                                <x-table.header.column class="border-x">Nama</x-table.header.column>
                                <x-table.header.column class="border-x">Kdgol</x-table.header.column>
                                <x-table.header.column class="border-x">Bruto</x-table.header.column>
                                <x-table.header.column class="border-x">PPh</x-table.header.column>
                                <x-table.header.column class="border-x">Netto</x-table.header.column>
                                <x-table.header.column class="border-x">Rekening</x-table.header.column>
                                <x-table.header.column class="border-x">Nama Bank</x-table.header.column>
                            </tr>
                        </x-table.header>
                        <x-table.body>
                            @foreach ($data as $item)
                            <tr class="">
                                <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="border">{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column class="border">{{ $item->kodegolongan }}</x-table.body.column>
                                @if ($item->nominal) 
                                <x-table.body.column class="border text-right">{{  number_format($item->nominal->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="border text-right">{{ number_format($item->nominal->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="border text-right">{{ number_format($item->nominal->netto, 2, ',', '.') }}</x-table.body.column>
                                @else 
                                <x-table.body.column class="border text-right"></x-table.body.column>
                                <x-table.body.column class="border text-right"></x-table.body.column>
                                <x-table.body.column class="border text-right"></x-table.body.column>
                                @endif
                                <x-table.body.column class="border">{{ $item->rekening }}</x-table.body.column>
                                <x-table.body.column class="border">{{ $item->namabank }}</x-table.body.column>
                            </tr>
                            @endforeach
                        </x-table.body>
                    </x-table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {{$data->links()}}
            </div>
        </div>

    </main>
@endsection