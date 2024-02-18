@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Verifikasi</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
        </div>
        <div class="">
            <form action="" method="get" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" class="input input-sm input-bordered join-item"
                        placeholder="Nomor Tagihan" placeholder="Nomor Tagihan" value="{{ request('search') }}">
                    <button class="btn join-item btn-sm btn-neutral" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-primary-content border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Jenis Tagihan</th>
                    <th class="border border-base-content">Nomor</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Tgl SPM</th>
                    <th class="border border-base-content">Unit</th>
                    <th class="border border-base-content">PPK</th>
                    <th class="border border-base-content">Jenis Dokumen</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <td class="text-center border border-base-content">{{ $i }}</td>
                        <td class="border border-base-content text-center">
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
                        <td class="border border-base-content">
                            {{ indonesiaDate($item->tanggal_spm) }}
                        </td>
                        <td class="border border-base-content">{{ optional($item->unit)->namaunit }}</td>
                        <td class="border border-base-content">{{ optional($item->ppk)->nama }}</td>
                        <td class="border border-base-content">{{ optional($item->dokumen)->namadokumen }}</td>
                        <td class="text-right border border-base-content">
                            Rp{{ number_format($item->realisasi->sum('realisasi'), 2, ',', '.') }}</td>
                        <td class="border border-base-content">
                            <div class="join">
                                @if ($item->jnstagihan === '1')
                                    <a href="/verifikasi/{{ $item->id }}/edit"
                                        class="btn btn-xs btn-outline btn-neutral join-item">SPM</a>
                                @endif
                                <a href="/verifikasi/{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Dokumen</a>
                                <a href="/verifikasi/{{ $item->id }}/coa"
                                    class="btn btn-xs btn-outline btn-neutral join-item">COA</a>
                                <a href="/verifikasi/{{ $item->id }}/payroll"
                                    class="btn btn-xs btn-outline btn-neutral join-item">Payroll</a>
                                @if ($item->dokumen->statusrekanan === '1')
                                    <a href="/verifikasi/{{ $item->id }}/rekanan"
                                        class="btn btn-xs btn-outline btn-neutral join-item">Rekanan</a>
                                @endif
                                <button value="{{ $item->id }}"
                                    class="btn btn-xs btn-outline btn-error join-item reject-btn">Tolak</button>
                                <a href="/verifikasi/{{ $item->id }}/approve"
                                    class="btn btn-xs btn-outline btn-success join-item"
                                    onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Approve</a>
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
    <dialog id="reject_modal" class="modal">
        <div class="modal-box w-full max-w-md p-0">
            <div class="relative bg-primary py-2 px-4 flex justify-between align-middle text-primary-content">
                <p>Apakah anda yakin ingin menolak tagihan ini?</p>
                <button class="btn btn-sm btn-ghost reject-close-btn">✕</button>
            </div>
            <div class="p-4">
                <form action="@if (Session::has('tagihan_id'))/verifikasi/{{ Session::get('tagihan_id') }}/tolak @endif"
                    id="form-tolak" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Catatan:</span>
                        </label>
                        <input type="text" name="catatan"
                            class="input input-sm input-bordered  w-full @error('catatan') input-error @enderror"
                            value="{{ old('catatan') }}" />
                        <label class="label">
                            @error('catatan')
                                <span class="label-text-alt text-red-500">
                                    {{ $message }}
                                </span>
                            @enderror
                        </label>
                    </div>
                    <button class="btn btn-sm btn-accent">Submit</button>
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
                const action = "/verifikasi/" + $(this).val() + "/tolak"
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
