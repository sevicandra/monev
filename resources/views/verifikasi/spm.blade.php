@extends('layout.main')
@section('content')
<div class="bg-primary p-4">
    <h1 class="text-xl text-primary-content">SPM</h1>
</div>
    <div class="px-4">
        <form action="/verifikasi/{{ $data->id }}" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tanggal SPM:</span>
                </label>
                <input type="date" name="tanggal_spm"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tanggal_spm') input-error @enderror"
                    @if (isset($data->spm)) value="{{ $data->spm->tanggal_spm }}" @endif />
                <label class="label">
                    @error('tanggal_spm')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/verifikasi" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection