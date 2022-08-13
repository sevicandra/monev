@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Pagu</h1>
    </div>

    <form action="/pagu" method="post" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Program:</label>
                    <input type="text" name="program" class="form-control @error('program') is-invalid @enderror" value="{{ old('program') }}">
                    <div class="invalid-feedback">
                        @error('program')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Kegiatan:</label>
                    <input type="text" name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" value="{{ old('kegiatan') }}">
                    <div class="invalid-feedback">
                        @error('kegiatan')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">KRO:</label>
                    <input type="text" name="kro" class="form-control @error('kro') is-invalid @enderror" value="{{ old('kro') }}">
                    <div class="invalid-feedback">
                        @error('kro')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">RO:</label>
                    <input type="text" name="ro" class="form-control @error('ro') is-invalid @enderror" value="{{ old('ro') }}">
                    <div class="invalid-feedback">
                        @error('ro')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Komponen:</label>
                    <input type="text" name="komponen" class="form-control @error('komponen') is-invalid @enderror" value="{{ old('komponen') }}">
                    <div class="invalid-feedback">
                        @error('komponen')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Subkomponen:</label>
                    <input type="text" name="subkomponen" class="form-control @error('subkomponen') is-invalid @enderror" value="{{ old('subkomponen') }}">
                    <div class="invalid-feedback">
                        @error('subkomponen')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Akun:</label>
                    <input type="text" name="akun" class="form-control @error('akun') is-invalid @enderror" value="{{ old('akun') }}">
                    <div class="invalid-feedback">
                        @error('akun')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Anggaran:</label>
                    <input type="text" name="anggaran" class="form-control @error('anggaran') is-invalid @enderror" value="{{ old('anggaran') }}">
                    <div class="invalid-feedback">
                        @error('anggaran')
                            {{$message}}
                        @enderror
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="/pagu" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>
@endsection