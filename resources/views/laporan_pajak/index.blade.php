@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rekap Pungutan Pajak</h1>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/laporan-pajak/pph" class="btn btn-sm btn-outline-primary mt-1">PPh</a>
            <a href="/laporan-pajak/ppn" class="btn btn-sm btn-outline-primary mt-1 ml-2">PPN</a>
        </div>
        <div class="col-lg-5">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-10">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection