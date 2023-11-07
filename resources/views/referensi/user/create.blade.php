@extends('layout.main')

@section('content')
<div class="bg-primary p-4">
    <h1 class="text-xl text-primary-content">Tambah User</h1>
</div>
<div class="px-4">
    <form action="/user" method="post" autocomplete="off">
        @csrf
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Nama:</span>
            </label>
            <input type="text" name="nama"
                class="input input-sm input-bordered  w-full max-w-xs @error('nama') input-error @enderror"
                value="{{ old('nama') }}" />
            <label class="label">
                @error('nama')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">NIP:</span>
            </label>
            <input type="text" name="nip"
                class="input input-sm input-bordered  w-full max-w-xs @error('nip') input-error @enderror"
                value="{{ old('nip') }}" />
            <label class="label">
                @error('nip')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Kode Satker (6 Digit):</span>
            </label>
            <input type="text" name="satker"
                class="input input-sm input-bordered  w-full max-w-xs @error('satker') input-error @enderror"
                value="{{ old('satker') }}" />
            <label class="label">
                @error('satker')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Password:</span>
            </label>
            <input type="password" name="password"
                class="input input-sm input-bordered  w-full max-w-xs @error('password') input-error @enderror"
                value="{{ old('password') }}" />
            <label class="label">
                @error('password')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div>
            <a href="/user" class="btn btn-sm btn-accent">Batal</a>
            <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
        </div>
    </form>
</div>
@endsection