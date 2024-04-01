@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Verifikasi</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="flex gap-2">
            <a href="/rekap-payroll" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-primary-content border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">jnstagihan</th>
                    <th class="border border-base-content">notagihan</th>
                    <th class="border border-base-content">uraian</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Pajak</th>
                    <th class="border border-base-content">Admin</th>
                    <th class="border border-base-content">Netto</th>
                    <th class="border border-base-content">Sudah Transfer</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1 + ($data->currentPage() - 1) * $data->perPage();
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <td class="text-center border border-base-content">{{ $i++ }}</td>
                        <td class="border border-base-content">
                            @switch($item->tagihan->jnstagihan)
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
                        <td class="border border-base-content">{{ $item->tagihan->notagihan }}</td>
                        <td class="border border-base-content">{{ $item->tagihan->uraian }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->bruto, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->pajak, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->admin, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">{{ number_format($item->netto, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-center">
                            @if ($item->status)
                                YA
                                @else
                                BELUM
                            @endif
                        </td>
                    </tr>
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
                <form action="@if (Session::has('tagihan_id')) /verifikasi/{{ Session::get('tagihan_id') }}/tolak @endif"
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
@endsection

@section('pagination')
    {{ $data->links() }}
@endsection
