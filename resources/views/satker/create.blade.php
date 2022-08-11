@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Satker </h1>
        </div>

        <form action="/satker" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Kode Satker:</label>
                        <input type="text" name="kodesatker" class="form-control @error('kodesatker') is-invalid @enderror" value="{{ old('kodesatker') }}">
                        <div class="invalid-feedback">
                            @error('kodesatker')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Kode Satker Koordinator:</label>
                        <input type="text" name="kodesatkerkoordinator" class="form-control @error('kodesatkerkoordinator') is-invalid @enderror" value="{{ old('kodesatkerkoordinator') }}">
                        <div class="invalid-feedback">
                            @error('kodesatkerkoordinator')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Nama Satker:</label>
                        <input type="namasatker" name="namasatker" class="form-control @error('namasatker') is-invalid @enderror" value="{{ old('namasatker') }}">
                        <div class="invalid-feedback">
                            @error('namasatker')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/satker" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </main>
@endsection