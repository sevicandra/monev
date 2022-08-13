@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Dokumen </h1>
        </div>

        <form action="/dokumen" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Kode Dokumen:</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}">
                        <div class="invalid-feedback">
                            @error('kode')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">nama Dokumen:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        <div class="invalid-feedback">
                            @error('nama')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Status DNP:</label>
                        <select class="form-select form-select-sm mb-3" name="statusdnp">
                            <option value="0">Non DNP</option>
                            <option value="1">DNP</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Status PPH:</label>
                        <select class="form-select form-select-sm mb-3" name="statuspph">
                            <option value="0">Non PPH</option>
                            <option value="1">PPh</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/dokumen" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </main>
@endsection