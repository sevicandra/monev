@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah PPH </h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/pph" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Golongan:</span>
                </label>
                <input type="text" name="kodegolongan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kodegolongan') input-error @enderror"
                    value="{{ old('kodegolongan') }}" />
                <label class="label">
                    @error('kodegolongan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tarif PPH:</span>
                </label>
                <input type="text" name="tarifpph"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tarifpph') input-error @enderror"
                    value="{{ old('tarifpph') }}" />
                <label class="label">
                    @error('tarifpph')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/pph" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
