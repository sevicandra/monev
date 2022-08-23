@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">SP2D</h1>
    </div>

    <form action="/bendahara/{{ $data->id }}/sp2d" method="post" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mb-2">
                    <label for="">Tanggal SPM:</label>
                    <input type="date" name="tanggal_spm" class="form-control @error('tanggal_spm') is-invalid @enderror" @if (isset($data->spm)) value="{{ $data->spm->tanggal_spm }}" @endif placeholder="dd-mm-yyyy">
                    <div class="invalid-feedback">
                        @error('tanggal_spm')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Tanggal SP2D:</label>
                    <input type="date" name="tanggal_sp2d" class="form-control @error('tanggal_sp2d') is-invalid @enderror" @if (isset($data->spm)) value="{{ $data->spm->tanggal_sp2d }}" @endif placeholder="dd-mm-yyyy">
                    <div class="invalid-feedback">
                        @error('tanggal_sp2d')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nomor SP2D:</label>
                    <input type="text" name="nomor_sp2d" class="form-control @error('nomor_sp2d') is-invalid @enderror" @if (isset($data->spm)) value="{{ $data->spm->nomor_sp2d }}" @endif>
                    <div class="invalid-feedback">
                        @error('nomor_sp2d')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="/bendahara" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>
@endsection