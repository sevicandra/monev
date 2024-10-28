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
        <x-table class="collapse w-full">
            <x-table.header class="text-center">
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">Nama</x-table.header.column>
                    <x-table.header.column class="border-x">Nomor Rekening</x-table.header.column>
                    <x-table.header.column class="border-x">Bank</x-table.header.column>
                    <x-table.header.column class="border-x">Bruto</x-table.header.column>
                    <x-table.header.column class="border-x">Pajak</x-table.header.column>
                    <x-table.header.column class="border-x">Admin</x-table.header.column>
                    <x-table.header.column class="border-x">Netto</x-table.header.column>
                    <x-table.header.column class="border-x">Aksi</x-table.header.column>
                </tr>
            </x-table.header>
            <tbody>
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <x-table.body.column
                            class="text-center border">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->nama }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->norek }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item->bank }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->bruto, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->pajak, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->admin, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item->netto, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border">
                            <a href="/rekap-payroll/{{ $item->norek }}"
                                class="btn btn-xs btn-outline btn-neutral join-item">detail</a>
                        </x-table.body.column>
                    </tr>
                @endforeach
            </tbody>
        </x-table>
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
