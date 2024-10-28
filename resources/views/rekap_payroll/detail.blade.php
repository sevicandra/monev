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
            <a href="{{ url()->current() === Str::startsWith(url()->previous(), url()->current()) ? '/rekap-payroll' : url()->previous() }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full">
            <x-table.header>
                <tr class="text-center">
                    <th class="border-x">No</th>
                    <th class="border-x">jnstagihan</th>
                    <th class="border-x">notagihan</th>
                    <th class="border-x">uraian</th>
                    <th class="border-x">Bruto</th>
                    <th class="border-x">Pajak</th>
                    <th class="border-x">Admin</th>
                    <th class="border-x">Netto</th>
                    <th class="border-x">Sudah Transfer</th>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr class="whitespace-nowrap">
                        <x-table.body.column
                            class="text-center border">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</x-table.body.column>
                        <x-table.body.column class="border">
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
                        </x-table.body.column>
                        <x-table.body.column
                            class="border">{{ $item->tagihan->notagihan }}</x-table.body.column>
                        <x-table.body.column
                            class="border">{{ $item->tagihan->uraian }}</x-table.body.column>
                        <x-table.body.column
                            class="border text-right">{{ number_format($item->bruto, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column
                            class="border text-right">{{ number_format($item->pajak, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column
                            class="border text-right">{{ number_format($item->admin, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column
                            class="border text-right">{{ number_format($item->netto, 2, ',', '.') }}
                        </x-table.body.column>
                        <x-table.body.column class="border text-center">
                            @if ($item->status)
                                YA
                            @else
                                BELUM
                            @endif
                        </x-table.body.column>
                    </tr>
                @endforeach
            </x-table.body>
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
