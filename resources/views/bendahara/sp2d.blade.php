@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">SP2D</h1>
    </div>
    <div class="px-4">
        <form action="/bendahara/{{ $data->id }}/sp2d" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor Tagihan (5 digit):</span>
                </label>
                <input type="text" name="notagihan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('notagihan') input-error @enderror"
                    @if (isset($data->spm)) value="{{ $data->spm->no_spm }}" @elseif($data->jnstagihan == '1') value="{{ $data->notagihan }}" @endif />
                <label class="label">
                    @error('notagihan')
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
                    class="input input-sm input-bordered  w-full max-w-xs @error('tanggal_spm') input-error @enderror"
                    @if (isset($data->spm)) value="{{ $data->spm->tanggal_spm }}" @endif
                    placeholder="dd-mm-yyyy" />
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
                    <span class="label-text">Tanggal SP2D:</span>
                </label>
                <input type="date" name="tanggal_sp2d"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tanggal_sp2d') input-error @enderror"
                    @if (isset($data->spm)) value="{{ $data->spm->tanggal_sp2d }}" @endif
                    placeholder="dd-mm-yyyy" />
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
                    <span class="label-text">Nomor SP2D:</span>
                </label>
                <input type="text" name="nomor_sp2d"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nomor_sp2d') input-error @enderror"
                    @if (isset($data->spm)) value="{{ $data->spm->nomor_sp2d }}" @endif />
                <label class="label">
                    @error('nomor_sp2d')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <a href="/bendahara" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
