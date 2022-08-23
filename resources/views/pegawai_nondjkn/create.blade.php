@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Pegawai Non DJKN</h1>
    </div>

    <form action="/pegawai-nondjkn" method="post" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">NIP/NIK/NPWP:</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" >
                    <div class="invalid-feedback">
                        @error('nip')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Pegawai:</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                    <div class="invalid-feedback">
                        @error('nama')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Kode Golongan:</label>
                    <input type="text" name="kodegolongan" class="form-control @error('kodegolongan') is-invalid @enderror" value="{{ old('kodegolongan') }}">
                    <div class="invalid-feedback">
                        @error('kodegolongan')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nomor Rekening:</label>
                    <input type="text" name="rekening" class="form-control @error('rekening') is-invalid @enderror" value="{{ old('rekening') }}">
                    <div class="invalid-feedback">
                        @error('rekening')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Bank:</label>
                    <input type="text" name="namabank" class="form-control @error('namabank') is-invalid @enderror" value="{{ old('namabank') }}">
                    <div class="invalid-feedback">
                        @error('namabank')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Nama Rekening:</label>
                    <input type="text" name="namarekening" class="form-control @error('namarekening') is-invalid @enderror" value="{{ old('namarekening') }}">
                    <div class="invalid-feedback">
                        @error('namarekening')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="/pegawai-nondjkn" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>
@endsection