@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Tagihan</h1>
        </div>
        <form action="/tagihan/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph/{{ $data->id }}" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label for="">Objek Pajak:</label>
                        <select class="form-select form-select-sm mb-3" name="objek">
                            @foreach ($objekpajak as $obj)
                                <option value="{{$obj->id}}" @if ($obj->id === $data->objekpajak_id) selected @endif>{{$obj->kode}} / {{$obj->nama}} - {{$obj->jenis}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @error('objek')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jumlah PPh:</label>
                        <input type="text" name="pph" class="form-control @error('pph') is-invalid @enderror" value="{{ $data->pph }}">
                        <div class="invalid-feedback">
                            @error('pph')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/tagihan/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>

        </form>

    </main>
@endsection
