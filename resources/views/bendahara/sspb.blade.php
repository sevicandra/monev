@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Detail Pengembalian</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <form action="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb" method="post" autocomplete="off">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group mb-2">
                <label for="">SSPB:</label>
                <input type="text" name="nominal_sspb" class="form-control @error('nominal_sspb') is-invalid @enderror" @if (isset($realisasi->sspb)) value="{{ $realisasi->sspb->nominal_sspb }}" @endif>
                <div class="invalid-feedback">
                    @error('nominal_sspb')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="form-group mb-2">
                <label for="">Tanggal SSPB:</label>
                <input type="date" name="tanggal_sspb" class="form-control @error('tanggal_sspb') is-invalid @enderror" placeholder="dd-mm-yyyy" @if (isset($realisasi->sspb)) value="{{ $realisasi->sspb->tanggal_sspb }}" @endif>
                <div class="invalid-feedback">
                    @error('tanggal_sspb')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="form-group">
                <a href="/bendahara/{{ $tagihan->id }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
            </div>
        </div>
    </div>

    </form>

</main>
@endsection