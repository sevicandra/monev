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
                <a href="/cleansing/spp" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
        @if ((Session::has('rowsErrors')))
        <div class="divider"></div>
        <div class="overflow-y-auto">
            <table class="table border-collapse w-full border-base-content">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th class="border border-base-content">No</th>
                        <th class="border border-base-content">tagihan_id</th>
                        <th class="border border-base-content">no_spm</th>
                        <th class="border border-base-content">tanggal_spm</th>
                        <th class="border border-base-content">nomor_sp2d</th>
                        <th class="border border-base-content">tanggal_sp2d</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ((Session::get('rowsErrors')) as $item)
                        <tr class="@if($item->status) text-success @else text-error @endif">
                            <td class="border border-base-content text-center">{{ $item->row }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->tagihan_id }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->no_spm }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->tanggal_spm }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->nomor_sp2d }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->tanggal_sp2d }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection
