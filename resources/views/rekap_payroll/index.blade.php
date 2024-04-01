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
                        placeholder="Nama/Nomor Rekening" placeholder="Nomor Tagihan" value="{{ request('search') }}">
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
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">Nomor Rekening</th>
                    <th class="border border-base-content">Bank</th>
                    <th class="border border-base-content">Bruto</th>
                    <th class="border border-base-content">Pajak</th>
                    <th class="border border-base-content">Admin</th>
                    <th class="border border-base-content">Netto</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1 + ($data->currentPage() - 1) * $data->perPage();
                @endphp
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <td class="text-center border border-base-content">{{ $i++ }}</td>
                        <td class="border border-base-content">{{ $item->nama }}</td>
                        <td class="border border-base-content">{{ $item->norek }}</td>
                        <td class="border border-base-content">{{ $item->bank }}</td>
                        <td class="border border-base-content">{{ $item->bruto }}</td>
                        <td class="border border-base-content">{{ $item->pajak }}</td>
                        <td class="border border-base-content">{{ $item->admin }}</td>
                        <td class="border border-base-content">{{ $item->netto }}</td>
                        <td class="border border-base-content">
                            <a href="/rekap-payroll/{{ $item->norek }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">detail</a>
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

