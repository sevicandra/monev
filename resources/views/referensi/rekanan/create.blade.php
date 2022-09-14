@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Rekanan </h1>
        </div>

        <form action="/rekanan" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Nama Rekanan:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        <div class="invalid-feedback">
                            @error('nama')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">NPWP :</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="npwp">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">ID Pajak :</label>
                        <input type="text" name="idpajak" class="form-control @error('idpajak') is-invalid @enderror" value="{{ old('idpajak') }}" placeholder="NPWP/NIP">
                        <div class="invalid-feedback">
                            @error('idpajak')
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