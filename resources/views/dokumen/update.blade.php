@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Update Dokumen </h1>
        </div>

        <form action="/dokumen/{{ $data->id }}" method="post" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Kode Dokumen:</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ $data->kodedokumen }}">
                        <div class="invalid-feedback">
                            @error('kode')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">nama Dokumen:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $data->namadokumen }}">
                        <div class="invalid-feedback">
                            @error('nama')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Status DNP:</label>
                        <select class="form-select form-select-sm mb-3" name="statusdnp">
                            <option value="0" @if ($data->statusdnp === '0') selected @endif>Non DNP</option>
                            <option value="1" @if ($data->statusdnp === '1') selected @endif>DNP</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Status PPH:</label>
                        <select class="form-select form-select-sm mb-3" name="statuspph">
                            <option value="0" @if ($data->statuspph === '0') selected @endif>Non PPH</option>
                            <option value="1" @if ($data->statuspph === '1') selected @endif>PPH</option>
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