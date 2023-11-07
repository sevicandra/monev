@extends('layout.main')

@section('content')
<div class="bg-primary p-4">
    <h1 class="text-xl text-primary-content">Ubah Satuan Kerja </h1>
</div>
<div class="px-4 gap-2 overflow-y-auto">
    <form action="/satker/{{ $data->id }}" method="post" autocomplete="off">
        @method('PATCH')
        @csrf
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Kode Satker:</span>
            </label>
            <input type="text" name="kodesatker"
                class="input input-sm input-bordered  w-full max-w-xs @error('kodesatker') input-error @enderror"
                value="{{ $data->kodesatker }}" />
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
                <span class="label-text">Kode Satker Koordinator:</span>
            </label>
            <input type="text" name="kodesatkerkoordinator"
                class="input input-sm input-bordered  w-full max-w-xs @error('kodesatkerkoordinator') input-error @enderror"
                value="{{ $data->kodesatkerkoordinator }}" />
            <label class="label">
                @error('kodesatkerkoordinator')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Nama Satker:</span>
            </label>
            <input type="text" name="namasatker"
                class="input input-sm input-bordered  w-full max-w-xs @error('namasatker') input-error @enderror"
                value="{{ $data->namasatker }}" />
            <label class="label">
                @error('namasatker')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div>
            <a href="/satker" class="btn btn-sm btn-accent">Batal</a>
            <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
        </div>
    </form>
</div>
@endsection
