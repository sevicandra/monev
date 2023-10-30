@extends('layout.main')
@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">PPh {{ $rekanan->nama }}</h1>
        </div>
        <div class="row">
            <div class="col">
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-7">
                <a href="/monitoring-tagihan/{{ $tagihan->id }}/rekanan" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
            </div>
            <div class="col-lg-5">

            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th>No</th>
                                <th>Objek Pajak</th>
                                <th>Tarif</th>
                                <th>PPh</th>
                                <th>NOP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i }}</td>
                                <td>{{ $item->objekpajak->nama }}</td>
                                @if ($item->rekanan->npwp === 1)
                                <td>{{ $item->objekpajak->tarif}}%</td>
                                <td>{{ number_format(floor($item->pph*($item->objekpajak->tarif/100)), 2, ',', '.')}}</td>
                                <td>{{ number_format($item->pph, 2, ',', '.')}}</td>
                                @else
                                <td>{{ $item->objekpajak->tarifnonnpwp}}%</td>
                                <td>{{ number_format(floor($item->pph*($item->objekpajak->tarifnonnpwp/100)), 2, ',', '.')}}</td>
                                <td>{{ number_format($item->pph, 2, ',', '.')}}</td>
                                @endif
                            </tr>
                            @php
                                $i++;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                
            </div>
        </div>

    </main>
@endsection