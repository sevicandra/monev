@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Bulan</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/bulan" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Kode Bulan:</span>
                </label>
                <input type="text" name="kodebulan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kodebulan') input-error @enderror"
                    value="{{ old('kodebulan') }}" />
                <label class="label">
                    @error('kodebulan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama Bulan:</span>
                </label>
                <input type="text" name="namabulan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('namabulan') input-error @enderror"
                    value="{{ old('namabulan') }}" />
                <label class="label">
                    @error('namabulan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/bulan" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
