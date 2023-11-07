@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Dokumen </h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/dokumen/{{ $data->id }}" method="post" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Dokumen:</span>
                </label>
                <input type="text" name="kode"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kode') input-error @enderror"
                    value="{{ $data->kodedokumen }}" />
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
                    <span class="label-text">Nama Dokumen:</span>
                </label>
                <input type="text" name="nama"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nama') input-error @enderror"
                    value="{{ $data->namadokumen }}" />
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
                    <span class="label-text">Status DNP:</span>
                </label>
                <select type="text" name="statusdnp"
                    class="select select-sm select-bordered w-full max-w-xs @error('statusdnp') select-error @enderror">
                    <option value="0" @if ($data->statusdnp == 0) selected @endif>
                        Non DNP</option>
                    <option value="1" @if ($data->statusdnp == 1) selected @endif>
                        DNP</option>
                </select>
                <label class="label">
                    @error('statusdnp')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Status PPh:</span>
                </label>
                <select type="text" name="statuspph"
                    class="select select-sm select-bordered w-full max-w-xs @error('statuspph') select-error @enderror">
                    <option value="0" @if ($data->statuspph == 0) selected @endif>
                        Non PPh</option>
                    <option value="1" @if ($data->statuspph == 1) selected @endif>
                        PPh</option>
                </select>
                <label class="label">
                    @error('statuspph')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Status Rekanan:</span>
                </label>
                <select type="text" name="statusrekanan"
                    class="select select-sm select-bordered w-full max-w-xs @error('statusrekanan') select-error @enderror">
                    <option value="0" @if ($data->statusrekanan == 0) selected @endif>
                        Non Rekanan</option>
                    <option value="1" @if ($data->statusrekanan == 1) selected @endif>
                        Rekanan</option>
                </select>
                <label class="label">
                    @error('statusrekanan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/dokumen" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
