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
                    <th class="border-x">No</th>
                    <th class="border-x">COA</th>
                    <th class="border-x">Realisasi</th>
                </tr>
            </x-table.header>
            <x-table.body>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center align-top">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <a class="link link-primary" href="/cleansing/rekap-spm/{{ $item['program'] }}/{{ $item['kegiatan'] }}/{{ $item['kro'] }}"
                                target="_blank" rel="noopener noreferrer">
                                {{ $item['program'] }}.{{ $item['kegiatan'] }}.{{ $item['kro'] }}
                            </a>
                        </x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item['total'], 0, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
                <tr>
                    <x-table.body.column class="border text-center align-top" colspan="2">Total</x-table.body.column>
                    <x-table.body.column class="border text-right">{{ number_format($data->sum('total'), 0, ',', '.') }}</x-table.body.column>
                </tr>
            </x-table.body>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
