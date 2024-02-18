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
                <a href="/tagihan-blbi/{{ $tagihan->id }}/dnp-honorarium" class="btn btn-sm btn-accent">Batal</a>
                <a href="/dnp-honorarium/template" target="_blank"
                    class="btn btn-sm btn-accent">Template</a>
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
                            <th colspan="5" class="font-black">Payroll BNI</th>
                        </tr>
                        <tr class="align-middle">
                            <th class="border border-base-content">No</th>
                            <th class="border border-base-content">Nama</th>
                            <th class="border border-base-content">NIP/NIK/NRP/DLL</th>
                            <th class="border border-base-content">Dasar Pembayaran</th>
                            <th class="border border-base-content">Jabatan</th>
                            <th class="border border-base-content">Golongan</th>
                            <th class="border border-base-content">NPWP</th>
                            <th class="border border-base-content">Frekuensi</th>
                            <th class="border border-base-content">Tarif</th>
                            <th class="border border-base-content">Pajak</th>
                            <th class="border border-base-content">Nomor Rekening</th>
                            <th class="border border-base-content">Nama Rekening</th>
                            <th class="border border-base-content">Bank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Session::get('Errors') as $item)
                            <tr class="@if ($item->status) text-success @else text-error @endif">
                                <td class="border border-base-content text-center">{{ $item->row }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->nama }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->nip }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->dasar }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->jabatan }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->gol }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->npwp }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->frekuensi }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->nilai }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->pajak }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->norek }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->namarek }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->bank }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
