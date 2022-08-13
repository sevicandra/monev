@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah PPH </h1>
        </div>

        <form action="/pph" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Kode Golongan:</label>
                        <input type="text" name="kodegolongan" class="form-control @error('kodegolongan') is-invalid @enderror" value="{{ old('kodegolongan') }}">
                        <div class="invalid-feedback">
                            @error('kodegolongan')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tarif PPH:</label>
                        <input type="text" name="tarifpph" class="form-control @error('tarifpph') is-invalid @enderror" value="{{ old('tarifpph') }}">
                        <div class="invalid-feedback">
                            @error('tarifpph')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/pph" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </main>
@endsection