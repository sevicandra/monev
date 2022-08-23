@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Tagihan</h1>
    </div>

    <form action="{{ $upload }}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mb-2">
                    <label for="">Jenis Dokumen:</label>
                    <select class="form-select form-select-sm mb-3" name="berkas">
                        @foreach ($berkas as $item)
                            <option value="{{ $item->id }}" @if (old('berkas') === $item->id) selected @endif>{{ $item->namaberkas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="">Keterangan Dokumen:</label>
                    <input type="text" name="uraian" class="form-control @error('uraian') is-invalid @enderror" value="{{ old('uraian') }}">
                    <div class="invalid-feedback">
                        @error('uraian')
                            {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="">Pilih File:</label>
                    <input type="file" name="fileupload" class="form-control @error('fileupload') is-invalid @enderror" value="{{ old('fileupload') }}">
                    <div class="invalid-feedback">
                        @error('fileupload')
                            {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="{{ $back }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>

    </form>

</main>
@endsection