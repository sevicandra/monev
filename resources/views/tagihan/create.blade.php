@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Tagihan</h1>
        </div>


        <form action="/tagihan" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label for="">Nomor Tagihan:</label>
                        <input type="text" name="notagihan" class="form-control @error('notagihan') is-invalid @enderror" value="{{ old('notagihan') }}">
                        <div class="invalid-feedback">
                            @error('notagihan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Tanggal Tagihan:</label>
                        <input type="date" name="tgltagihan" class="form-control @error('tgltagihan') is-invalid @enderror" placeholder="dd-mm-yyyy" value="{{ old('tgltagihan') }}">
                        <div class="invalid-feedback">
                            @error('tgltagihan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Uraian Tagihan:</label>
                        <input type="text" name="uraian" class="form-control @error('uraian') is-invalid @enderror" value="{{ old('uraian') }}">
                        <div class="invalid-feedback">
                            @error('uraian')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jenis tagihan:</label>
                        <select class="form-select form-select-sm mb-3" name="jnstagihan">
                            <option value="0">SPBy</option>
                            <option value="1">SPP</option>
                        </select>
                        <div class="invalid-feedback">
                            @error('jnstagihan')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="">Unit:</label>
                        <select class="form-select form-select-sm mb-3" name="kodeunit">
                            @foreach ($unit as $item)
                            <option value="{{ $item->id }}" @if (old('kodeunit') === $item->id) selected @endif>{{ $item->namaunit }}</option>
                            
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @error('kodeunit')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jenis Dokumen:</label>
                        <select class="form-select form-select-sm mb-3" name="kodedokumen">
                            @foreach ($dokumen as $item)
                                <option value="{{ $item->id }}" @if (old('kodedokumen') === $item->id) selected @endif>{{ $item->namadokumen }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @error('kodedokumen')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/tagihan" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>

        </form>

    </main>
@endsection
