@extends('layout.main')

@section('head')
    
@endsection


@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="row">
        <div class="col">
            <div class="d-flex flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="display-6">Realisasi </h1> <span class="mt-1 ml-2" style="font-size: large;"></span>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <a href="" class="btn btn-sm btn-outline-primary">Per Tagihan</a>
            <a href="" class="btn btn-sm btn-outline-primary ml-2">Per SP2D</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th>Nomor</th>
                                <th>Jenis Belanja</th>
                                <th>Pagu</th>
                                <th>Realisasi</th>
                                <th>Sisa Pagu</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                               
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-3 mr-1 ml-1">
                <div class="card chart-container">
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b>Realisasi per PPK</b>
                        <span><b>Persentase</b></span>
                    </li>

                </ul>
            </div>
        </div>
    </div>


</main>
@endsection

@section('foot')
    
@endsection

