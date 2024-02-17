@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Import Data Excel</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="px-4 gap-2">
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
                <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll" class="btn btn-sm btn-accent">Batal</a>
                <a href="/tagihan-blbi/payroll/excel/template" class="btn btn-sm btn-accent">Template</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
    @if ((Session::has('bniErrors')))
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
                        <th class="border border-base-content">No. Rekening</th>
                        <th class="border border-base-content">Nama</th>
                        <th class="border border-base-content">Bruto</th>
                        <th class="border border-base-content">Pajak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ((Session::get('bniErrors')) as $item)
                        <tr class="@if($item->status) text-success @else text-error @endif">
                            <td class="border border-base-content text-center">{{ $item->row }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->NOREK }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->NAMA }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->BRUTO }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->PAJAK }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @if ((Session::has('nonBniErrors')))
    <div class="px-4 gap-2">
        <div class="divider"></div>
        <div class="overflow-y-auto">
            <table class="table border-collapse w-full border-base-content">
                <thead class="text-center">
                    <tr class="align-middle">
                        <th colspan="7" class="font-black">Payroll NON BNI</th>
                    </tr>
                    <tr class="align-middle">
                        <th class="border border-base-content">No</th>
                        <th class="border border-base-content">No. Rekening</th>
                        <th class="border border-base-content">Nama</th>
                        <th class="border border-base-content">Bruto</th>
                        <th class="border border-base-content">Pajak</th>
                        <th class="border border-base-content">Biaya Adm.</th>
                        <th class="border border-base-content">Bank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ((Session::get('nonBniErrors')) as $item)
                        <tr class="@if($item->status) text-success @else text-error @endif">
                            <td class="border border-base-content text-center">{{ $item->row }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->NOREK }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->NAMA }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->BRUTO }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->PAJAK }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->ADMIN }}</td>
                            <td class="border border-base-content text-center">{{ $item->errors->BANK }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection
