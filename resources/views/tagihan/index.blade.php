@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tagihan</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/tagihan/create" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
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
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Uraian</th>
                    <th class="border border-base-content">PIC</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Unit</th>
                    <th class="border border-base-content">Jenis Dokumen</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1 + ($data->currentPage() - 1) * $data->perPage();
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap @if ($item->catatan) text-error @endif">
                        <td class="border border-base-content text-center"
                            @if ($item->catatan) rowspan="2" @endif>{{ $i }}</td>
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
                        <td class="border border-base-content" style="white-space:normal; min-width:300px">
                            {{ $item->uraian }}</td>
                        <td class="border border-base-content">{{ optional($item->stafPpk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->ppk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->unit)->namaunit }}</td>
                        <td class="border border-base-content">{{ optional($item->dokumen)->namadokumen }}</td>
                        <td class="border border-base-content text-right">
                            Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                        <td class="border border-base-content" @if ($item->catatan) rowspan="2" @endif>
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
                                @if ($item->realisasi->sum('realisasi') > 0 || $item->berkasupload->first())
                                    <button value="{{ $item->id }}"
                                        class="btn btn-xs btn-outline btn-success join-item kirim-btn">Kirim</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @if ($item->catatan)
                        <tr>
                            <td colspan="9" class="border border-base-content py-2 border-dashed">
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
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
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
