@extends('layout.main')
@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">SPM</h1>
    </div>

    <form action="/ppspm/{{ $data->id }}" method="post" autocomplete="off">
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
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="/ppspm" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>
    </form>

</main>
@endsection