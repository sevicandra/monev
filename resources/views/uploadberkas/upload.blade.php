@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Upload Tagihan</h1>
    </div>
    <div class="px-4">
        <form action="{{ $upload }}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Jenis Dokumen:</span>
                </label>
                <select type="text" name="berkas"
                    class="select select-sm select-bordered w-full max-w-xs @error('berkas') select-error @enderror">
                    @foreach ($berkas as $item)
                        <option value="{{ $item->kodeberkas }}" @if (old('berkas') === $item->kodeberkas) selected @endif>
                            {{ $item->namaberkas }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('berkas')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Keterangan Dokumen:</span>
                </label>
                <input type="text" name="uraian"
                    class="input input-sm input-bordered  w-full max-w-xs @error('uraian') input-error @enderror"
                    value="{{ old('uraian') }}" />
                <label class="label">
                    @error('uraian')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Pilih File:</span>
                </label>
                <input type="file" name="fileupload"
                    class="file-input file-input-sm file-input-bordered  w-full max-w-xs @error('fileupload') file-input-error @enderror"
                    value="{{ old('fileupload') }}" />
                <label class="label">
                    @error('fileupload')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @else
                        <span class="label-text-alt text-primary">
                            File pdf, xls, xlsx, zip, rar
                        </span> 
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <a href="{{ $back }}" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
