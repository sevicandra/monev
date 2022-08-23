@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kirim Tagihan</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="" method="post">
                @csrf
                @method('POST')
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Passphrase BSSN:</label>
                        <input type="password" name="passphrase" class="form-control @error('passphrase') is-invalid @enderror">
                        <div class="invalid-feedback">
                            @error('passphrase')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <a href="/register" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Proses</button>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>
</main>
@endsection