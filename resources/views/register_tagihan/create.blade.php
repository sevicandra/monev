<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Register Tagihan</h1>
    </div>

    <form action="" method="post" autocomplete="off">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-2">
                    <label for="">Nomor register:</label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor') }}">
                    <div class="invalid-feedback">
                        @error('nomor')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">tanggal:</label>
                    <input type="text" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                    <div class="invalid-feedback">
                        @error('tanggal')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Jumlah:</label>
                    <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}">
                    <div class="invalid-feedback">
                        @error('jumlah')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Status:</label>
                    <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status') }}">
                    <div class="invalid-feedback">
                        @error('status')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>