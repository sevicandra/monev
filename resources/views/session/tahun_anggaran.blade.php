@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Ubah Tahun Anggaran</h1>
        </div>

        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>

        <form action="" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group mb-2">
                        <label for="">Tahun Anggaran:</label>
                        <select class="form-select form-select-sm mb-3" name="tahun">
                            @foreach ($tahun as $item)
                                <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <a href="" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
@endsection