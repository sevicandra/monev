@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Unit</h1>
    </div>

    <form action="/unit/{{ $data->id }}" method="post" autocomplete="off">
    @method('PATCH')
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Kode Unit:</label>
                <input type="text" name="kodeunit" class="form-control @error('kodeunit') is-invalid @enderror" value="{{ $data->kodeunit }}">
                <div class="invalid-feedback">
                    @error('kodeunit')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Nama Unit:</label>
                <input type="text" name="namaunit" class="form-control @error('namaunit') is-invalid @enderror" value="{{ $data->namaunit }}">
                <div class="invalid-feedback">
                    @error('namaunit')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="/unit" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>
@endsection