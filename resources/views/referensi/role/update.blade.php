@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Role</h1>
    </div>

    <form action="/role/{{ $data->id }}" method="post" autocomplete="off">
    @method('PATCH')
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Kode Role:</label>
                <input type="text" name="koderole" class="form-control @error('koderole') is-invalid @enderror" value="{{ $data->koderole }}">
                <div class="invalid-feedback">
                    @error('koderole')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Role:</label>
                <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ $data->role }}">
                <div class="invalid-feedback">
                    @error('role')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="/role" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>
@endsection