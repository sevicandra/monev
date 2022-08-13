@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Import Data Excel</h1>
    </div>
    <form action="/pagu/import" method="post" autocomplete="off" enctype="multipart/form-data">
      @csrf
        <div class="row mb-3">
            <div class="col-lg-3">
                <input type="file" class="form-control form-control-sm" placeholder="file" name="berkas_excel">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="form-group">
                    <a href="/pagu" class="btn btn-sm btn-outline-secondary">Batal</a>
                    <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</main>
    
@endsection
  