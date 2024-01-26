@extends('layout.main')

@section('content')
<div class="bg-primary p-4">
    <h1 class="text-xl text-primary-content">Ubah PPH</h1>
</div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="" method="post" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">NIP:</span>
                </label>
                <input type="text" name="nip"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nip') input-error @enderror"
                    value="{{ $data->nip }}" />
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
                    <span class="label-text">Nama:</span>
                </label>
                <input type="text" name="nama"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nama') input-error @enderror"
                    value="{{ $data->nama }}" />
                <label class="label">
                    @error('nama')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/ref-ppk" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
