@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Verifikasi-kkp</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
        </div>
        <div class="">
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
    <div class="px-4 gap-2 overflow-y-auto">
        <x-tagihan :jenis="false" :uraian="false" :nomor_spm="false" :tanggal_spm="false" :nomor_sp2d="false"
            :tanggal_sp2d="false" :status="false" :pic="false">
            @foreach ($data as $item)
                <tr class="whitespace-nowrap">
                    <td class="text-center border" rowspan="{{ $item->catatan ? 2 : 1 }}">
                        {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                    <td class="border">{{ $item->notagihan }}</td>
                    <td class="border">{{ indonesiaDate($item->tgltagihan) }}</td>
                    <td class="border">{{ optional($item->unit)->namaunit }}</td>
                    <td class="border">{{ optional($item->ppk)->nama }}</td>
                    <td class="border">{{ optional($item->dokumen)->namadokumen }}</td>
                    <td class="text-right border">
                        Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                    <x-table.body.column class="border">{{ indonesiaDate($item->updated_at) }}</x-table.body.column>
                    <td class="border" rowspan="{{ $item->catatan ? 2 : 1 }}">
                        <div class="join">
                            <a href="/verifikasi-kkp/{{ $item->id }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                            <a href="/verifikasi-kkp/{{ $item->id }}/coa"
                                class="btn btn-xs btn-outline btn-neutral join-item">COA</a>
                            <button value="{{ $item->id }}"
                                class="btn btn-xs btn-outline btn-error join-item reject-btn">Tolak</button>
                            <a href="/verifikasi-kkp/{{ $item->id }}/approve"
                                class="btn btn-xs btn-outline btn-success join-item"
                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
                        </div>
                    </td>
                </tr>
                @if ($item->catatan)
                    <tr>
                        <td colspan="9" class="border py-2 border-dashed">
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
                        </td>
                    </tr>
                @endif
            @endforeach
        </x-tagihan>
    </div>
    <dialog id="reject_modal" class="modal">
        <div class="modal-box w-full max-w-5xl p-0">
            <div class="relative bg-primary py-2 px-4 flex justify-between align-middle text-primary-content">
                <p>Apakah anda yakin ingin menolak tagihan ini?</p>
                <button class="btn btn-sm btn-ghost reject-close-btn">✕</button>
            </div>
            <div class="p-4">
                <form enctype="multipart/form-data"
                    action="@if (Session::has('tagihan_id')) /verifikasi-kkp/{{ Session::get('tagihan_id') }}/tolak @endif"
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
            reject_modal.showModal();
        </script>
    @enderror
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            $(".reject-btn").click(function() {
                reject_modal.showModal()
                const action = "/verifikasi-kkp/" + $(this).val() + "/tolak"
                $("#form-tolak").attr("action", action);
            });
            $(".reject-close-btn").click(function() {
                reject_modal.close()
                const action = ""
                $("#form-tolak").attr("action", action);
            })
        });
    </script>
@endsection
