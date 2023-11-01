@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Detail Akun</h1>
    </div>

    <form action="/tagihan/realisasi/{{ $data->id }}" method="post" autocomplete="off"> 
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">Realisasi (Bruto):</label>
                <input type="text" name="realisasi" class="form-control " value="{{ $data->realisasi }}">
                <div class="invalid-feedback">
                    @error('realisasi')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="/tagihan/{{ $data->tagihan->id }}/realisasi" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>
    
@endsection