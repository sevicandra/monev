@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Import Data Excel</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/pagu/import" method="post" autocomplete="off" enctype="multipart/form-data">
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
                <a href="/pagu" class="btn btn-sm btn-accent">Batal</a>
                <a href="/pagu/template" class="btn btn-sm btn-accent">Template</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
