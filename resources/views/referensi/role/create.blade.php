@extends('layout.main')

@section('content')
<div class="bg-primary p-4">
    <h1 class="text-xl text-primary-content">Tambah Role</h1>
</div>
<div class="px-4 gap-2 overflow-y-auto">
    <form action="/role" method="post" autocomplete="off">
        @csrf
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Kode Role:</span>
            </label>
            <input type="text" name="koderole"
                class="input input-sm input-bordered  w-full max-w-xs @error('koderole') input-error @enderror"
                value="{{ old('koderole') }}" />
            <label class="label">
                @error('koderole')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Role:</span>
            </label>
            <input type="text" name="role"
                class="input input-sm input-bordered  w-full max-w-xs @error('role') input-error @enderror"
                value="{{ old('role') }}" />
            <label class="label">
                @error('role')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div>
            <a href="/role" class="btn btn-sm btn-accent">Batal</a>
            <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
        </div>
    </form>
</div>
@endsection