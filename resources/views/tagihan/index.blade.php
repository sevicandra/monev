@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tagihan</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col px-4 gap-2 justify-between">
        <div class="">
            <a href="/tagihan/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
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
        <x-tagihan :nomor_spm="false" :tanggal_spm="false" :nomor_sp2d="false" :tanggal_sp2d="false" :status="false"
            :update="false">
            @foreach ($data as $item)
                <tr class="whitespace-nowrap @if ($item->catatan) text-error @endif">
                    <x-table.body.column class="border text-center" rowspan="{{ $item->catatan ? 2 : 1 }}">
                        {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</x-table.body.column>
                    <x-table.body.column class="border">
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
                    <x-table.body.column class="border" style="white-space:normal; min-width:300px">
                        {{ $item->uraian }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->ppk)->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->unit)->namaunit }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->stafPpk)->nama }}</x-table.body.column>
                    <x-table.body.column class="border">{{ optional($item->dokumen)->namadokumen }}</x-table.body.column>
                    <x-table.body.column class="border text-right">
                        Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</x-table.body.column>
                    <x-table.body.column class="border" rowspan="{{ $item->catatan ? 2 : 1 }}">
                        <div class="join">
                            <a href="/tagihan/{{ $item->id }}/edit"
                                class="btn btn-xs btn-neutral btn-outline join-item">Ubah</a>
                            <a href="/tagihan/{{ $item->id }}/realisasi"
                                class="btn btn-xs btn-neutral btn-outline join-item">Realisasi</a>
                            {{-- @if ($item->dokumen->statusdnp === '1')
                                <a href="/tagihan/{{ $item->id }}/dnp" class="btn btn-xs btn-neutral btn-outline join-item">DNP</a>
                                @endif --}}
                            @if ($item->dokumen->dnp_perjadin)
                                <a href="/tagihan/{{ $item->id }}/dnp-perjadin"
                                    class="btn btn-xs btn-neutral btn-outline join-item">DNP Perjadin</a>
                            @endif
                            @if ($item->dokumen->dnp_honor)
                                <a href="/tagihan/{{ $item->id }}/dnp-honorarium"
                                    class="btn btn-xs btn-neutral btn-outline join-item">DNP Honor</a>
                            @endif
                            @if ($item->dokumen->statusrekanan === '1')
                                <a href="/tagihan/{{ $item->id }}/rekanan"
                                    class="btn btn-xs btn-neutral btn-outline join-item">Rekanan</a>
                            @endif
                            <a href="/tagihan/{{ $item->id }}/upload"
                                class="btn btn-xs btn-neutral btn-outline join-item">Upload</a>
                            <a href="/tagihan/{{ $item->id }}/payroll"
                                class="btn btn-xs btn-neutral btn-outline join-item">Payroll</a>
                            <form action="/tagihan/{{ $item->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-xs btn-error btn-outline join-item"
                                    onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');">Hapus</button>
                            </form>
                            @if (($item->dokumen->realisasi === 0 || $item->realisasi->sum('realisasi') > 0) && $item->berkasupload->first())
                                <button value="{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-success join-item kirim-btn">Kirim</button>
                            @endif
                        </div>
                    </x-table.body.column>
                </tr>
                @if ($item->catatan)
                    <tr>
                        <x-table.body.column colspan="9" class="border py-2 border-dashed">
                            <button class="btn btn-xs btn-error"
                                onclick="catatan_{{ $loop->iteration }}.showModal()">catatan</button>
                            <dialog id="catatan_{{ $loop->iteration }}" class="modal">
                                <div
                                    class="modal-box w-11/12 max-w-5xl max-h-11/12 grid grid-rows-[auto_auto_1fr] overflow-hidden gap-2 p-0">
                                    <div class="flex justify-end glass p-2">
                                        <button class="btn btn-sm btn-ghost"
                                            onclick="catatan_{{ $loop->iteration }}.close()">✕</button>
                                    </div>
                                    <div class="p-2 flex flex-col gap-2">
                                        <hr>
                                    </div>
                                    <div class="rich-text overflow-y-auto px-4 py-2">
                                        {!! $item->catatan !!}
                                    </div>
                                </div>
                            </dialog>
                        </x-table.body.column>
                    </tr>
                @endif
            @endforeach
        </x-tagihan>
    </div>
    <dialog id="kirim_modal" class="modal">
        <div class="modal-box w-full max-w-5xl p-0">
            <div class="relative bg-primary py-2 px-4 flex justify-between align-middle text-primary-content">
                <p>Notes</p>
                <button id="trix-close-btn" class="btn btn-sm btn-ghost kirim-close-btn">✕</button>
            </div>
            <div class="p-4">
                <form enctype="multipart/form-data"
                    action="@if (Session::has('tagihan_id')) /verifikasi/{{ Session::get('tagihan_id') }}/tolak @endif"
                    id="form-tolak" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Catatan:</span>
                        </label>
                        <x-trix-input id="catatan" name="catatan" value="{{ old('catatan') }}" acceptFiles="true" />
                        <label class="label">
                            @error('catatan')
                                <span class="label-text-alt text-red-500">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                    </div>
                    <button type="button" id="trix-submit-btn" class="btn btn-sm btn-accent">Submit</button>
                </form>
            </div>
        </div>
    </dialog>
    @error('catatan')
        <script>
            kirim_modal.showModal();
        </script>
    @enderror
@endsection
@section('pagination')
    {{ $data->links() }}
@endsection
@section('foot')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <script>
        $(document).ready(function() {
            $(".kirim-btn").click(function() {
                kirim_modal.showModal()
                const action = "/tagihan/" + $(this).val() + "/kirim"
                $("#form-tolak").attr("action", action);
            });
            $(".kirim-close-btn").click(function() {
                kirim_modal.close()
                const action = ""
                $("#form-tolak").attr("action", action);
            })
        });
    </script>
@endsection
