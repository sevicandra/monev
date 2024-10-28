@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Rekap SPM</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">

        </div>
        <div class="">

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-table class="collapse w-full max-w-3xl">
            <x-table.header>
                <tr class="text-center">
                    <x-table.header.column class="border-x">No</x-table.header.column>
                    <x-table.header.column class="border-x">SPM</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal SPM</x-table.header.column>
                    <x-table.header.column class="border-x">SP2D</x-table.header.column>
                    <x-table.header.column class="border-x">Tanggal SP2D</x-table.header.column>
                    <x-table.header.column class="border-x">Realisasi</x-table.header.column>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column
                            class="border text-center align-top">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item['no_spm'] }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item['tanggal_spm'] }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item['nomor_sp2d'] }}</x-table.body.column>
                        <x-table.body.column class="border">{{ $item['tanggal_sp2d'] }}</x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item['nominal'], 0, ',', '.') }}
                        </x-table.body.column>
                    </tr>
                @endforeach
                <tr>
                    <x-table.body.column class="border text-center align-top" colspan="5">Total</x-table.body.column>
                    <x-table.body.column
                        class="border text-right">{{ number_format($data->sum('nominal'), 0, ',', '.') }}</x-table.body.column>
                </tr>
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
