@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Dokumen </h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/dokumen" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Dokumen:</span>
                </label>
                <input type="text" name="kode"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kode') input-error @enderror"
                    value="{{ old('kode') }}" />
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
                    value="{{ old('nama') }}" />
                <label class="label">
                    @error('nama')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            {{-- <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text">Status DNP:</span>
                    <input type="checkbox" name="statusdnp" class="checkbox checkbox-primary" value="TRUE" />
                </label>
            </div> --}}

            {{-- <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text">Status PPh:</span>
                    <input type="checkbox" name="statuspph" class="checkbox checkbox-primary" value="TRUE" />
                </label>
            </div> --}}

            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">Status Rekanan:</span>
                    <input type="checkbox" name="statusrekanan" class="checkbox checkbox-primary" value=1 @if (old('statusrekanan')) checked @endif />
                </label>
            </div>

            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">DNP Perjadin:</span>
                    <input type="checkbox" name="dnpperjadin" class="checkbox checkbox-primary" value=1 @if (old('dnpperjadin')) checked @endif />
                </label>
            </div>

            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">DNP Honor:</span>
                    <input type="checkbox" name="dnphonor" class="checkbox checkbox-primary" value=1 @if (old('dnphonor')) checked @endif/>
                </label>
            </div>

            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">Realisasi:</span>
                    <input type="checkbox" name="realisasi" class="checkbox checkbox-primary" value=1 @if (old('realisasi')) checked @endif/>
                </label>
            </div>

            <div class="form-control w-full max-w-xs">
                <label class="label cursor-pointer">
                    <span class="label-text">BLBI:</span>
                    <input type="checkbox" name="blbi" class="checkbox checkbox-primary" value=1 @if (old('blbi')) checked @endif/>
                </label>
            </div>

            <div>
                <a href="/dokumen" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
