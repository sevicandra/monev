@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Cleansing Tagihan</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col px-4 gap-2 justify-between">
        <div class="">
            <a href="{{ url()->current() === Str::before(url()->previous(), '?') ? '/cleansing/spm' : url()->previous() }}"
                class="btn btn-sm btn-neutral btn-outline">Kembali</a>
        </div>
        <div class="flex gap-2 justify-between items-center flex-wrap">
            <div>
                <div class="flex gap-1">
                    <a href="{{ request()->fullUrlWithQuery(['jns' => '']) }}"
                        class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'ALL' ? 'btn-active' : '' }}">ALL</a>
                    <a href="{{ request()->fullUrlWithQuery(['jns' => 'SPBY']) }}"
                        class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'SPBY' ? 'btn-active' : '' }}">SPBY</a>
                    <a href="{{ request()->fullUrlWithQuery(['jns' => 'SPP']) }}"
                        class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'SPP' ? 'btn-active' : '' }}">SPP</a>
                    <a href="{{ request()->fullUrlWithQuery(['jns' => 'KKP']) }}"
                        class="btn btn-sm btn-neutral btn-outline {{ request('jns', 'ALL') === 'KKP' ? 'btn-active' : '' }}">KKP</a>
                </div>
            </div>
            <div>
                <form action="" method="get" autocomplete="off">
                    <input type="hidden" name="jns" value="{{ request('jns', 'ALL') }}">
                    <input type="hidden" name="sb" value="{{ request('sb', 'nomor_tagihan') }}">
                    <input type="hidden" name="sd" value="{{ request('sd', 'desc') }}">
                    <div class="join">
                        <input type="text" name="search" class="input input-sm input-bordered join-item"
                            placeholder="Nomor Tagihan/Uraian">
                        <div class="indicator">
                            <button class="btn join-item btn-sm btn-neutral">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-tagihan :nomor_spm="false" :tanggal_spm="false" :nomor_sp2d="false" :tanggal_sp2d="false" :pic="false"
            :status="false" :update="false">
            @foreach ($data as $item)
                <tr class="whitespace-nowrap">
                    <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border text-center">
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
                    </x-table.body.column>
                    <x-table.body.column class="border">{{ $item->notagihan }}</x-table.body.column>
                    <x-table.body.column class="border">{{ indonesiaDate($item->tgltagihan) }}</x-table.body.column>
                    <x-table.body.column class="border"
                        style="white-space:normal; min-width:300px">{{ $item->uraian }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->unit)->namaunit }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->ppk)->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->dokumen)->namadokumen }}</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format(optional($item->realisasi)->sum('realisasi'), 0, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <form action="/cleansing/spm/{{ $item->spm_id }}/tagihan/{{ $item->id }}/delete"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-error btn-outline join-item">Hapus</button>
                        </form>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-tagihan>
    </div>
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
