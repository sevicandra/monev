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
        <table class="table border-collapse w-full max-w-3xl">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">COA</th>
                    <th class="border border-base-content">Realisasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center align-top">{{ $loop->iteration }}</td>
                        <td class="border border-base-content text-center">
                            <a class="link link-primary" href="/cleansing/rekap-spm/{{ $item['program'] }}/{{ $item['kegiatan'] }}/{{ $item['kro'] }}"
                                target="_blank" rel="noopener noreferrer">
                                {{ $item['program'] }}.{{ $item['kegiatan'] }}.{{ $item['kro'] }}
                            </a>
                        </td>
                        <td class="border border-base-content text-right">{{ number_format($item['total'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="border border-base-content text-center align-top" colspan="2">Total</td>
                    <td class="border border-base-content text-right">{{ number_format($data->sum('total'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('pagination')
    {{-- {{ $data->links() }} --}}
@endsection
