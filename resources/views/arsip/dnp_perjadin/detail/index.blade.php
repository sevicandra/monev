@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="h2">Detail DNP Perjadin</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-hidden ">
        @php
            $a = 0;
            $b = 0;
            $c = 0;
            $d = 0;
            $e = 0;
            use App\Helper\NumberToWord;
        @endphp

        <div class="grid grid-template-rows-[auto_1fr] gap-2 overflow-y-hidden h-full">
            <div class="overflow-y-auto">
                <table class="table border-collapse whitespace-nowrap max-full max-w-5xl">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th class="border border-base-content">No</th>
                            <th class="border border-base-content">Rincian Biaya</th>
                            <th class="border border-base-content">Jumlah</th>
                            <th class="border border-base-content">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="biayaAngkutan">
                        <tr>
                            <td class="border-x border-t border-base-content text-center align-top">1</td>
                            <td class="border-x border-t border-base-content">Biaya Angkutan</td>
                            <td class="border-x border-t border-base-content text-end"></td>
                            <td class="border-x border-t border-base-content"></td>
                        </tr>

                        @foreach (json_decode($dnp->transport) ?? [] as $item)
                            @php
                                $a += $item->nilai;
                            @endphp
                            <tr>
                                <td class="border-x border-base-content"></td>
                                <td class="border-x border-base-content">
                                    {{ $item->nama }}
                                </td>
                                <td class="border-x border-base-content text-end">
                                    {{ number_format($item->nilai, 2, ',', '.') }}
                                </td>
                                <td class="border-x border-base-content">
                                    {{ $item->keterangan }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody id="biayaTransportasiLain">
                        <tr>
                            <td class="border-x border-t border-base-content text-center align-top	">2</td>
                            <td class="border-x border-t border-base-content">Transportasi Lain-Lain</td>
                            <td class="border-x border-t border-base-content text-end"></td>
                            <td class="border-x border-t border-base-content"></td>
                        </tr>
                        @foreach (json_decode($dnp->transportLain) ?? [] as $item)
                            @php
                                $b += $item->nilai;
                            @endphp
                            <tr>
                                <td class="border-x border-base-content"></td>
                                <td class="border-x border-base-content">{{ $item->nama }}</td>
                                <td class="border-x border-base-content text-end">{{ number_format($item->nilai, 2, ',', '.') }}</td>
                                <td class="border-x border-base-content">{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody id="biayaUangHarian">
                        <tr>
                            <td class="border-x border-t border-base-content text-center align-top	">3</td>
                            <td class="border-x border-t border-base-content">Satuan Uang Harian/Uang Saku Perjalanan Dinas
                                <br> Selama:</td>
                            <td class="border-x border-t border-base-content"></td>
                            <td class="border-x border-t border-base-content"></td>
                        </tr>
                        @foreach (json_decode($dnp->uangharian) ?? [] as $item)
                            @php
                                $c += $item->frekuensi * $item->nilai;
                            @endphp
                            <tr>
                                <td class="border-x border-base-content"></td>
                                <td class="border-x border-base-content">{{ $item->frekuensi }} Hari x
                                    {{ number_format($item->nilai, 2, ',', '.') }}</td>
                                <td class="border-x border-base-content text-end">
                                    {{ number_format($item->frekuensi * $item->nilai, 2, ',', '.') }} </td>
                                <td class="border-x border-base-content">{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody id="biayaPenginapan">
                        <tr>
                            <td class="border-x border-t border-base-content text-center align-top	">4</td>
                            <td class="border-x border-t border-base-content">Biaya Penginapan <br> Selama:</td>
                            <td class="border-x border-t border-base-content"></td>
                            <td class="border-x border-t border-base-content"></td>
                        </tr>
                        @foreach (json_decode($dnp->penginapan) ?? [] as $item)
                            @php
                                $d += $item->frekuensi * $item->nilai;
                            @endphp
                            <tr>
                                <td class="border-x border-base-content"></td>
                                <td class="border-x border-base-content">{{ $item->frekuensi }} Hari x
                                    {{ number_format($item->nilai, 2, ',', '.') }} </td>
                                <td class="border-x border-base-content text-end">
                                    {{ number_format($item->frekuensi * $item->nilai, 2, ',', '.') }}</td>
                                <td class="border-x border-base-content">{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody id="uangRepresentatif">
                        <tr>
                            <td class="border-x border-t border-base-content text-center align-top	">5</td>
                            <td class="border-x border-t border-base-content">Uang Respresentatif <br> Selama:</td>
                            <td class="border-x border-t border-base-content"></td>
                            <td class="border-x border-t border-base-content"></td>
                        </tr>
                        @foreach (json_decode($dnp->representatif) ?? [] as $item)
                            @php
                                $e += $item->frekuensi * $item->nilai;
                            @endphp
                            <tr>
                                <td class="border-x border-base-content"></td>
                                <td class="border-x border-base-content">{{ $item->frekuensi }} Hari x
                                    {{ number_format($item->nilai, 2, ',', '.') }}</td>
                                <td class="border-x border-base-content text-end">
                                    {{ number_format($item->frekuensi * $item->nilai, 2, ',', '.') }}</td>
                                <td class="border-x border-base-content">{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody>
                        <tr>
                            <td class="border border-base-content text-center" colspan="2">Total</td>
                            <td class="border border-base-content text-end font-bold">
                                Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.') }}</td>
                            <td class="border border-base-content"></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="border border-base-content text-center font-bold">
                                {{ NumberToWord::toWords($a + $b + $c + $d + $e) }} Rupiah
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
