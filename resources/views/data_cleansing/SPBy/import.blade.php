@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Import Data Excel</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="px-4 gap-2 overflow-y-hidden flex flex-col">
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="form-control w-full max-w-xs">
                <input type="file" name="file"
                    class="file-input file-input-sm file-input-bordered  w-full max-w-xs @error('file') file-input-error @enderror"
                    value="{{ old('file') }}" />
                <label class="label">
                    @error('file')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/cleansing/spby" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
        @if ((Session::has('rowsErrors')))
        <div class="divider"></div>
        <div class="overflow-y-auto">
            <x-table class="collapse w-full">
                <x-table.header>
                    <tr class="text-center">
                        <x-table.header.column class="border-x">No</x-table.header.column>
                        <x-table.header.column class="border-x">tagihan_id</x-table.header.column>
                        <x-table.header.column class="border-x">no_spm</x-table.header.column>
                        <x-table.header.column class="border-x">tanggal_spm</x-table.header.column>
                        <x-table.header.column class="border-x">nomor_sp2d</x-table.header.column>
                        <x-table.header.column class="border-x">tanggal_sp2d</x-table.header.column>
                    </tr>
                </x-table.header>
                <tbody>
                    @foreach ((Session::get('rowsErrors')) as $item)
                        <tr class="@if($item->status) text-success @else text-error @endif">
                            <x-table.body.column class="border text-center">{{ $item->row }}</x-table.body.column>
                            <x-table.body.column class="border text-center">{{ $item->errors->tagihan_id }}</x-table.body.column>
                            <x-table.body.column class="border text-center">{{ $item->errors->no_spm }}</x-table.body.column>
                            <x-table.body.column class="border text-center">{{ $item->errors->tanggal_spm }}</x-table.body.column>
                            <x-table.body.column class="border text-center">{{ $item->errors->nomor_sp2d }}</x-table.body.column>
                            <x-table.body.column class="border text-center">{{ $item->errors->tanggal_sp2d }}</x-table.body.column>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>
        </div>
        @endif
    </div>
@endsection
