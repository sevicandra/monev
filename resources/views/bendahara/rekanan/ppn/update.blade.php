@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Tagihan</h1>
        </div>
        <form action="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/{{ $data->id }}" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label for="">Nomor Faktur:</label>
                        <input type="text" name="nomorfaktur" class="form-control @error('nomorfaktur') is-invalid @enderror" value="{{ $data->nomorfaktur }}">
                        <div class="invalid-feedback">
                            @error('nomorfaktur')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tanggal Faktur:</label>
                        <input type="date" name="tanggalfaktur" class="form-control @error('tanggalfaktur') is-invalid @enderror" placeholder="dd-mm-yyyy" value="{{ $data->tanggalfaktur }}">
                        <div class="invalid-feedback">
                            @error('tanggalfaktur')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tarif:</label>
                        <select class="form-select form-select-sm mb-3" name="tarif">
                            <option value="0.11" @if ($data->tarif === 0.11) selected @endif>11%</option>
                            <option value="0.01"@if ($data->tarif === 0.01) selected @endif>1%</option>
                        </select>
                        <div class="invalid-feedback">
                            @error('tarif')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Dasar Pengenaan Pajak:</label>
                        <input type="text" name="ppn" class="form-control @error('ppn') is-invalid @enderror" value="{{ $data->ppn }}">
                        <div class="invalid-feedback">
                            @error('ppn')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    @if ($tagihan->jnstagihan === '0')
                    <div class="form-group mb-2">
                        <label for="">NTPN:</label>
                        <input type="text" name="ntpn" class="form-control @error('ntpn') is-invalid @enderror" value="{{ $data->ntpn }}">
                        <div class="invalid-feedback">
                            @error('ntpn')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tanggal NTPN:</label>
                        <input type="date" name="tanggalntpn" class="form-control @error('tanggalntpn') is-invalid @enderror" value="{{ $data->tanggalntpn }}">
                        <div class="invalid-feedback">
                            @error('tanggalntpn')
                                {{$message}}
                            @enderror
                        </div>
                    </div>                        
                    @endif
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>

        </form>

    </main>
@endsection
