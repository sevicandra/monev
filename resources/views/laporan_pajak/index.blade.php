@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Rekap Pungutan Pajak</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/laporan-pajak/pph" class="btn btn-sm btn-neutral">PPh</a>
            <a href="/laporan-pajak/ppn" class="btn btn-sm btn-neutral">PPN</a>
        </div>
        <div>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border border-collapse w-full">
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
@endsection
