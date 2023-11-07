@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Berkas</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/berkas/{{ $data->id }}" method="post" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Berkas:</span>
                </label>
                <input type="text" name="kode"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kode') input-error @enderror"
                    value="{{ $data->kodeberkas }}" />
                <label class="label">
                    @error('kode')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Berkas:</span>
                </label>
                <input type="text" name="berkas"
                    class="input input-sm input-bordered  w-full max-w-xs @error('berkas') input-error @enderror"
                    value="{{ $data->namaberkas }}" />
                <label class="label">
                    @error('berkas')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/berkas" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
