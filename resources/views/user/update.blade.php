@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah User</h1>
    </div>

    <form action="/user/{{ $data->id }}" method="post" autocomplete="off">
    @method('PATCH')
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Nama:</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ $data->nama }}">
                <div class="invalid-feedback">
                    @error('nama')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">NIP:</label>
                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ $data->nip }}">
                <div class="invalid-feedback">
                    @error('nip')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Email:</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $data->email }}">
                <div class="invalid-feedback">
                    @error('email')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Satker:</label>
                <input type="text" name="satker" class="form-control @error('satker') is-invalid @enderror" value="{{ $data->satker }}">
                <div class="invalid-feedback">
                    @error('satker')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="/user" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>
@endsection