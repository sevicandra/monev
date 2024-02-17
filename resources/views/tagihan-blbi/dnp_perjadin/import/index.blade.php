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
                <a href="/tagihan-blbi/{{ $tagihan->id }}/dnp-perjadin" class="btn btn-sm btn-accent">Batal</a>
                <a href="/tagihan-blbi/{{ $tagihan->id }}/dnp-perjadin/template" target="_blank"
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
                            <th class="border border-base-content">Unit Kerja</th>
                            <th class="border border-base-content">Surat Tugas</th>
                            <th class="border border-base-content">Lokasi</th>
                            <th class="border border-base-content">Durasi</th>
                            <th class="border border-base-content">Nomor Rekening</th>
                            <th class="border border-base-content">Nama Rekening</th>
                            <th class="border border-base-content">Bank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Session::get('Errors') as $item)
                            <tr class="@if ($item->status) text-success @else text-error @endif">
                                <td class="border border-base-content text-center">{{ $item->row }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->NAMA }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->NIP }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Unit_Kerja }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Surat_Tugas }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Lokasi }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Durasi }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Nomor_Rekening }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Nama_Rekening }}</td>
                                <td class="border border-base-content text-center">{{ $item->errors->Bank }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
