@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah SPM</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/cleansing/spm/{{ $data->id }}" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor SPM (5 digit):</span>
                </label>
                <input type="text" name="nomor_spm"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nomor_spm') input-error @enderror"
                    value="{{ $data->nomor_spm }}" />
                <label class="label">
                    @error('nomor_spm')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tanggal SPM:</span>
                </label>
                <input type="date" name="tanggal_spm"
                    class="input input-sm input-bordered w-full max-w-xs @error('tanggal_spm') input-error @enderror"
                    placeholder="dd-mm-yyyy" value="{{ $data->tanggal_spm }}" />
                <label class="label">
                    @error('tanggal_spm')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Jenis SPM:</span>
                </label>
                <input type="text" name="jenis_spm"
                    class="input input-sm input-bordered  w-full max-w-xs @error('jenis_spm') input-error @enderror"
                    value="{{ $data->jenis_spm }}" />
                <label class="label">
                    @error('jenis_spm')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor SP2D:</span>
                </label>
                <input type="text" name="nomor_sp2d"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nomor_sp2d') input-error @enderror"
                    value="{{ $data->nomor_sp2d }}" />
                <label class="label">
                    @error('nomor_sp2d')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tanggal SP2D:</span>
                </label>
                <input type="date" name="tanggal_sp2d"
                    class="input input-sm input-bordered w-full max-w-xs @error('tanggal_sp2d') input-error @enderror"
                    placeholder="dd-mm-yyyy" value="{{ $data->tanggal_sp2d }}" />
                <label class="label">
                    @error('tanggal_sp2d')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Deskripsi:</span>
                </label>
                <textarea type="text" name="deskripsi" maxlength="255"
                    class="textarea textarea-sm textarea-bordered  w-full max-w-xs @error('deskripsi') textarea-error @enderror">{{ $data->deskripsi }}</textarea>
                <label class="label">
                    @error('deskripsi')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <a href="{{ url()->current() === Str::before(url()->previous(), '?') ? '/cleansing/spm' : url()->previous() }}" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
