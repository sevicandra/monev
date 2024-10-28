@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">COA</h1>
    </div>
    <div class="flex flex-col lg:flex-row px-4 gap-2 justify-between">
        <div class="lg:basis-5/12 flex gap-2">
            <a href="/arsip" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
        <div class="lg:basis-7/12 overflow-hidden max-w-full shrink">
            <form action="" method="get" autocomplete="off">
                <div class="join flex max-w-full justify-end">
                    <input type="text" name="program" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('program') }}" placeholder="Program">
                    <input type="text" name="kegiatan" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('kegiatan') }}" placeholder="Kegiatan">
                    <input type="text" name="kro" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('kro') }}" placeholder="KRO">
                    <input type="text" name="ro" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('ro') }}" placeholder="RO">
                    <input type="text" name="komponen" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('komponen') }}" placeholder="Komponen">
                    <input type="text" name="subkomponen" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('subkomponen') }}" placeholder="Subkomponen">
                    <input type="text" name="akun" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('akun') }}" placeholder="Akun">
                    <button class="btn btn-sm btn-outline join-item" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-coa :anggaran="false" :aksi="false" :sisa="FALSE">
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ optional($item->pagu)->program }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ optional($item->pagu)->kegiatan }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ optional($item->pagu)->kro }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ optional($item->pagu)->ro }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ optional($item->pagu)->komponen }}</x-table.body.column>
                    <x-table.body.column
                        class="border text-center">{{ optional($item->pagu)->subkomponen }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ optional($item->pagu)->akun }}</x-table.body.column>
                    <x-table.body.column
                        class="text-right border">{{ number_format($item->realisasi, 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="text-right border">
                        @if (isset($item->sspb))
                            {{ number_format($item->sspb->sum('nominal_sspb'), 2, ',', '.') }}
                        @endif
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-coa>
    </div>
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
