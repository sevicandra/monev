@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Nomor Register</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/nomor" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor register:</span>
                </label>
                <input type="text" name="nomor"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nomor') input-error @enderror"
                    value="{{ old('nomor') }}" />
                <label class="label">
                    @error('nomor')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Satker:</span>
                </label>
                <input type="text" name="kodesatker"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kodesatker') input-error @enderror"
                    value="{{ old('kodesatker') }}" />
                <label class="label">
                    @error('kodesatker')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tahun:</span>
                </label>
                <input type="text" name="tahun"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tahun') input-error @enderror"
                    value="{{ old('tahun') }}" />
                <label class="label">
                    @error('tahun')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/nomor" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
