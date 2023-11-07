@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Rekanan </h1>
    </div>
    <div class="px-4">
        <form action="/rekanan" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama Rekanan:</span>
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
            <div class="form-control  w-full max-w-xs">
                <label class="cursor-pointer label">
                    <span class="label-text">NPWP:</span>
                    <input name="npwp" type="checkbox" checked="checked" class="checkbox checkbox-info" />
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">ID Pajak :</span>
                </label>
                <input type="text" name="idpajak"
                    class="input input-sm input-bordered  w-full max-w-xs @error('idpajak') input-error @enderror"
                    value="{{ old('idpajak') }}" placeholder="NPWP/NIK" />
                <label class="label">
                    @error('idpajak')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/rekanan" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
