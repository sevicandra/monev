@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Objek Pajak </h1>
        </div>

        <form action="/referensi/objek-pajak" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Kode Objek:</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" placeholder="xx-xxx-xx">
                        <div class="invalid-feedback">
                            @error('kode')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Nama Objek:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        <div class="invalid-feedback">
                            @error('nama')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jenis Pajak:</label>
                        <input type="text" name="jenis" class="form-control @error('jenis') is-invalid @enderror" value="{{ old('jenis') }}">
                        <div class="invalid-feedback">
                            @error('jenis')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tarif:</label>
                        <input type="text" name="tarif" class="form-control @error('tarif') is-invalid @enderror" value="{{ old('tarif') }}">
                        <div class="invalid-feedback">
                            @error('tarif')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tarif Non NPWP:</label>
                        <input type="text" name="tarifnonnpwp" class="form-control @error('tarifnonnpwp') is-invalid @enderror" value="{{ old('tarifnonnpwp') }}">
                        <div class="invalid-feedback">
                            @error('tarifnonnpwp')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/referensi/objek-pajak" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </main>
@endsection