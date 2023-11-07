@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Unit</h1>
    </div>
    <div class="px-4">
        <form action="/unit/{{ $data->id }}" method="post" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Unit:</span>
                </label>
                <input type="text" name="kodeunit"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kodeunit') input-error @enderror"
                    value="{{ $data->kodeunit }}" />
                <label class="label">
                    @error('kodeunit')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama Unit:</span>
                </label>
                <input type="text" name="namaunit"
                    class="input input-sm input-bordered  w-full max-w-xs @error('namaunit') input-error @enderror"
                    value="{{ $data->namaunit }}" />
                <label class="label">
                    @error('namaunit')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/unit" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
