@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Satker </h1>
        </div>

        <form action="/tahun/{{ $data->id }}" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Tahun:</label>
                        <input type="text" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{{ $data->tahun }}}">
                        <div class="invalid-feedback">
                            @error('tahun')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/tahun" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </main>
@endsection