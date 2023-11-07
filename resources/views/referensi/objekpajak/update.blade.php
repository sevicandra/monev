@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Objek Pajak </h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/referensi/objek-pajak/{{ $data->id }}" method="post" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Objek:</span>
                </label>
                <input type="text" name="kode"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kode') input-error @enderror"
                    value="{{ $data->kode }}" placeholder="xx-xxx-xx"/>
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
                    <span class="label-text">Nama Objek:</span>
                </label>
                <input type="text" name="nama"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nama') input-error @enderror"
                    value="{{ $data->nama }}"/>
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
                    <span class="label-text">Jenis Pajak:</span>
                </label>
                <input type="text" name="jenis"
                    class="input input-sm input-bordered  w-full max-w-xs @error('jenis') input-error @enderror"
                    value="{{ $data->jenis }}"/>
                <label class="label">
                    @error('jenis')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tarif:</span>
                </label>
                <input type="text" name="tarif"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tarif') input-error @enderror"
                    value="{{ $data->tarif }}"/>
                <label class="label">
                    @error('tarif')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tarif Non NPWP:</span>
                </label>
                <input type="text" name="tarifnonnpwp"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tarifnonnpwp') input-error @enderror"
                    value="{{ $data->tarifnonnpwp }}"/>
                <label class="label">
                    @error('tarifnonnpwp')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/referensi/objek-pajak" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
