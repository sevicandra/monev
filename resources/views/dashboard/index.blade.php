@extends('layout.main')

@section('head')
    <style>
        .chart-container {
            width: 100%;
            height: 100%;
            margin: auto;
        }
    </style>
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
            <a href="/dashboard" class="btn btn-sm btn-outline-primary">Per Tagihan</a>
            <a href="/dashboard?sp2d=?" class="btn btn-sm btn-outline-primary ml-2">Per SP2D</a>
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
                                <td class="text-center">1</td>
                                <td>Belanja Pegawai</td>
                                <td class="text-right">{{ number_format($belanjapegawai->sum('anggaran'), 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($realisasibelanjapegawai->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($belanjapegawai->sum('anggaran')-$realisasibelanjapegawai->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">
                                    @if ($realisasibelanjapegawai->sum('realisasi'))
                                        {{ number_format($realisasibelanjapegawai->sum('realisasi')*100 /$belanjapegawai->sum('anggaran'), 2, ',', '.') }}%
                                    @else
                                        0,00%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Belanja Barang</td>
                                <td class="text-right">{{ number_format($belanjabarang->sum('anggaran'), 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($realisasibelanjabarang->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($belanjabarang->sum('anggaran')-$realisasibelanjabarang->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">
                                    @if ($realisasibelanjabarang->sum('realisasi'))
                                        {{ number_format($realisasibelanjabarang->sum('realisasi')*100 /$belanjabarang->sum('anggaran'), 2, ',', '.') }}%
                                    @else
                                        0,00%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Belanja Modal</td>
                                <td class="text-right">{{ number_format($belanjamodal->sum('anggaran'), 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($realisasibelanjamodal->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($belanjamodal->sum('anggaran')-$realisasibelanjamodal->sum('realisasi'), 2, ',', '.') }}</td>
                                <td class="text-right">
                                    @if ($realisasibelanjamodal->sum('realisasi'))
                                        {{ number_format($realisasibelanjamodal->sum('realisasi')*100 /$belanjamodal->sum('anggaran'), 2, ',', '.') }}%
                                    @else
                                        0,00%
                                    @endif
                                </td>
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
                    @foreach ($ppk as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->nama }}
                        <span class="badge bg-warning rounded-pill">
                            @if ($item->paguppk->sum('anggaran') != 0)
                                {{ number_format($item->realisasippk()->sum('realisasi')*100 /$item->paguppk->sum('anggaran'), 2, ',', '.') }}% 
                            @else
                                0%
                            @endif

                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</main>
@endsection

@section('foot')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<!-- bar chart -->
<script>
    const ctx = document.getElementById("chart").getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @php
                    foreach($unit as $item){
                        echo '"'.$item->namaunit.'",';
                    }
                @endphp
            ],
            datasets: [{
                label: 'Realisasi per Unit',
                backgroundColor: 'rgba(161, 198, 247, 1)',
                borderColor: 'rgb(47, 128, 237)',
                 data: [
                    @php
                        foreach($unit as $item){
                            echo '"'.($item->realisasi()->sum('realisasi')-$item->sspb()->sum('nominal_sspb'))*100/$item->pagu()->sum('anggaran').'",';
                        }
                    @endphp
                 ],
                
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            }
        },
    });
</script>
@endsection

