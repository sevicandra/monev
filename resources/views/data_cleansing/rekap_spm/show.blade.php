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
                    <x-table.header.column class="border-x">Program</x-table.header.column>
                    <x-table.header.column class="border-x">Kegiatan</x-table.header.column>
                    <x-table.header.column class="border-x">KRO</x-table.header.column>
                    <x-table.header.column class="border-x">Akun</x-table.header.column>
                    <x-table.header.column class="border-x">Realisasi</x-table.header.column>
                </tr>
            </x-table.header>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <x-table.body.column class="border text-center align-top">{{ $loop->iteration }}</x-table.body.column>
                        <x-table.body.column class="border text-center align-top">{{ $item['program'] }}</x-table.body.column>
                        <x-table.body.column class="border text-center align-top">{{ $item['kegiatan'] }}</x-table.body.column>
                        <x-table.body.column class="border text-center align-top">{{ $item['kro'] }}</x-table.body.column>
                        <x-table.body.column class="border text-center">
                            <a class="link link-primary"
                                href="/cleansing/rekap-spm/{{ $item['program'] }}/{{ $item['kegiatan'] }}/{{ $item['kro'] }}/{{ $item['akun'] }}">
                                {{ $item['akun'] }}
                            </a>
                        </x-table.body.column>
                        <x-table.body.column class="border text-right">{{ number_format($item['total'], 0, ',', '.') }}</x-table.body.column>
                    </tr>
                @endforeach
                <tr>
                    <td class="border text-center align-top" colspan="5">Total</td>
                    <td class="border text-right">{{ number_format($data->sum('total'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </x-table>
    </div>
@endsection
@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
