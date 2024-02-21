@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Import Data Excel</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-hidden flex flex-col">
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="form-control w-full max-w-xs">
                <input type="file" name="berkas_excel"
                    class="file-input file-input-sm file-input-bordered  w-full max-w-xs @error('berkas_excel') file-input-error @enderror"
                    value="{{ old('berkas_excel') }}" />
                <label class="label">
                    @error('file')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/pagu" class="btn btn-sm btn-accent">Batal</a>
                <a href="/pagu/cetak" class="btn btn-sm btn-accent">Template</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
    @if (Session::has('Errors'))
        <div class="px-4 gap-2">
            <div class="divider"></div>
            <div class="overflow-y-auto">
                <table class="table border-collapse w-full border-base-content">
                    <thead class="text-center">
                        <tr class="align-middle">
                        </tr>
                        <tr class="align-middle">
                            <th class="border border-base-content">id</th>
                            <th class="border border-base-content">program</th>
                            <th class="border border-base-content">kegiatan</th>
                            <th class="border border-base-content">kro</th>
                            <th class="border border-base-content">ro</th>
                            <th class="border border-base-content">komponen</th>
                            <th class="border border-base-content">subkomponen</th>
                            <th class="border border-base-content">akun</th>
                            <th class="border border-base-content">anggaran</th>
                            <th class="border border-base-content">kodeunit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Session::get('Errors') as $item)
                            <tr class="@if ($item->status) text-success @else text-error @endif">
                                <td class="border border-base-content text-center">{{ $item->errors->id }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->program }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->kegiatan }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->kro }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->ro }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->komponen }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->subkomponen }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->akun }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->anggaran }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->kodeunit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
