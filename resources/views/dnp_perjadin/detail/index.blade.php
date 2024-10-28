@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Detail DNP Perjadin</h1>
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
        <form action="" method="post" autocomplete="off" class="h-full">
            @csrf
            @method('PATCH')
            <div class="grid grid-template-rows-[auto_1fr] gap-2 overflow-y-hidden h-full">
                <div>
                    <button class="btn btn-sm btn-primary">
                        Simpan
                    </button>
                </div>
                <div class="overflow-y-auto">
                    <table class="table border-collapse whitespace-nowrap max-full max-w-5xl">
                        <thead class="text-center">
                            <tr class="align-middle">
                                <th class="border border-base-content">No</th>
                                <th class="border border-base-content">Rincian Biaya</th>
                                <th class="border border-base-content">Jumlah</th>
                                <th class="border border-base-content">Keterangan</th>
                                <th class="border border-base-content">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="biayaAngkutan">
                            <tr>
                                <td class="border-x border-t border-base-content text-center align-top">1</td>
                                <td class="border-x border-t border-base-content">Biaya Angkutan
                                    <button id="tambahBiayaAngkutan" class="btn btn-success btn-xs" type="button">
                                        Tambah
                                    </button>
                                </td>
                                <td class="border-x border-t border-base-content text-end"></td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                            </tr>

                            @foreach (json_decode($dnp->transport) ?? [] as $item)
                                @php
                                    $a += $item->nilai;
                                @endphp
                                <tr>
                                    <td class="border-x border-base-content"></td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->nama }}" name="namaBiayaAngkutan[]">
                                    </td>
                                    <td class="border-x border-base-content nominal">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs nominal"
                                            value="{{ $item->nilai }}" name="nilaiBiayaAngkutan[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->keterangan }}" name="keteranganBiayaAngkutan[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <button name="hapusBiayaAngkutan" class="btn btn-error btn-xs" type="button">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody id="biayaTransportasiLain">
                            <tr>
                                <td class="border-x border-t border-base-content text-center align-top	">2</td>
                                <td class="border-x border-t border-base-content">Transportasi Lain-Lain
                                    <button id="tambahBiayaTransportasiLain" class="btn btn-success btn-xs" type="button">
                                        Tambah
                                    </button>
                                </td>
                                <td class="border-x border-t border-base-content text-end"></td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                            </tr>
                            @foreach (json_decode($dnp->transportLain) ?? [] as $item)
                                @php
                                    $b += $item->nilai;
                                @endphp
                                <tr>
                                    <td class="border-x border-base-content"></td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->nama }}" name="namaBiayaTransportasiLain[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs nominal"
                                            value="{{ $item->nilai }}" name="nilaiBiayaTransportasiLain[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->keterangan }}" name="keteranganBiayaTransportasiLain[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <button name="hapusBiayaTransportasiLain" class="btn btn-error btn-xs"
                                            type="button">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody id="biayaUangHarian">
                            <tr>
                                <td class="border-x border-t border-base-content text-center align-top	">3</td>
                                <td class="border-x border-t border-base-content">Satuan Uang Harian/Uang Saku Perjalanan
                                    Dinas <button id="tambahBiayaUangHarian" class="btn btn-success btn-xs" type="button">
                                        Tambah
                                    </button><br>
                                    Selama:</td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                            </tr>
                            @foreach (json_decode($dnp->uangharian) ?? [] as $item)
                                @php
                                    $c += $item->frekuensi * $item->nilai;
                                @endphp
                                <tr>
                                    <td class="border-x border-base-content"></td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered"
                                            value="{{ $item->frekuensi }}" name="frekuensiUangHarian[]"> Hari x
                                        <input type="text" class="input input-sm input-bordered nominal"
                                            value="{{ $item->nilai }}" name="nilaiUangHarian[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text"
                                            class="input input-sm input-bordered w-full max-w-xs nominal"
                                            value="{{ $item->frekuensi * $item->nilai }}" disabled>
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->keterangan }}" name="keteranganUangHarian[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <button name="hapusBiayaUangHarian" class="btn btn-error btn-xs" type="button">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody id="biayaPenginapan">
                            <tr>
                                <td class="border-x border-t border-base-content text-center align-top	">4</td>
                                <td class="border-x border-t border-base-content">Biaya Penginapan <button
                                        id="tambahBiayaPenginapan" class="btn btn-success btn-xs" type="button">
                                        Tambah
                                    </button> <br> Selama:</td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                            </tr>
                            @foreach (json_decode($dnp->penginapan) ?? [] as $item)
                                @php
                                    $d += $item->frekuensi * $item->nilai;
                                @endphp
                                <tr>
                                    <td class="border-x border-base-content"></td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered"
                                            name="frekuensiPenginapan[]" value="{{ $item->frekuensi }}"> Hari x
                                        <input type="text" class="input input-sm input-bordered nominal"
                                            name="nilaiPenginapan[]" value="{{ $item->nilai }}">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text"
                                            class="input input-sm input-bordered w-full max-w-xs nominal" disabled
                                            value="{{ $item->frekuensi * $item->nilai }}">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->keterangan }}" name="keteranganPenginapan[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <button name="hapusBiayaPenginapan" class="btn btn-error btn-xs" type="button">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody id="uangRepresentatif">
                            <tr>
                                <td class="border-x border-t border-base-content text-center align-top	">5</td>
                                <td class="border-x border-t border-base-content">Uang Respresentatif <button
                                        id="tambahUangRepresentatif" class="btn btn-success btn-xs" type="button">
                                        Tambah
                                    </button> <br> Selama:</td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                                <td class="border-x border-t border-base-content"></td>
                            </tr>
                            @foreach (json_decode($dnp->representatif) ?? [] as $item)
                                @php
                                    $e += $item->frekuensi * $item->nilai;
                                @endphp
                                <tr>
                                    <td class="border-x border-base-content"></td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered"
                                            value="{{ $item->frekuensi }}" name="frekuensiRepresentatif[]"> Hari x
                                        <input type="text" class="input input-sm input-bordered nominal"
                                            value="{{ $item->nilai }}" name="nilaiRepresentatif[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text"
                                            class="input input-sm input-bordered w-full max-w-xs nominal"
                                            value="{{ $item->frekuensi * $item->nilai }}" disabled>
                                    </td>
                                    <td class="border-x border-base-content">
                                        <input type="text" class="input input-sm input-bordered w-full max-w-xs"
                                            value="{{ $item->keterangan }}" name="keteranganRepresentatif[]">
                                    </td>
                                    <td class="border-x border-base-content">
                                        <button name="hapusUangRepresentatif" class="btn btn-error btn-xs"
                                            type="button">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr>
                                <td class="border border-base-content text-center" colspan="2">Total</td>
                                <td class="border border-base-content text-end font-bold">
                                    Rp{{ number_format($a + $b + $c + $d + $e, 0, ',', '.') }}</td>
                                <td class="border border-base-content"></td>
                                <td class="border border-base-content"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="border border-base-content text-center font-bold">
                                    {{ NumberToWord::toWords($a + $b + $c + $d + $e) }} Rupiah
                                </td>
                                <td class="border border-base-content text-end font-bold"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('foot')
    <script>
        $(document).ready(function() {
            $('#tambahBiayaAngkutan').click(function() {

                $('#biayaAngkutan').append(`
                    <tr>
                        <td class="border-x border-base-content"></td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="namaBiayaAngkutan[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs nominal" name="nilaiBiayaAngkutan[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="keteranganBiayaAngkutan[]">
                        </td>
                        <td class="border-x border-base-content">
                            <button name="hapusBiayaAngkutan" 
                                class="btn btn-error btn-xs" type="button">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `)
            })

            $('#biayaAngkutan').on('click', 'button[name="hapusBiayaAngkutan"]', function() {
                $(this).parent().parent().remove()
            })

            $('#tambahBiayaTransportasiLain').click(function() {

                $('#biayaTransportasiLain').append(`
                    <tr>
                        <td class="border-x border-base-content"></td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="namaBiayaTransportasiLain[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs nominal" name="nilaiBiayaTransportasiLain[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="keteranganBiayaTransportasiLain[]">
                        </td>
                        <td class="border-x border-base-content">
                            <button name="hapusBiayaTransportasiLain" 
                                class="btn btn-error btn-xs" type="button">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `)
            })

            $('#biayaTransportasiLain').on('click', 'button[name="hapusBiayaTransportasiLain"]', function() {
                $(this).parent().parent().remove()
            })

            $('#tambahBiayaUangHarian').click(function() {

                $('#biayaUangHarian').append(`
                    <tr>
                        <td class="border-x border-base-content"></td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered" name="frekuensiUangHarian[]"> Hari x
                            <input type="text" class="input input-sm input-bordered nominal" name="nilaiUangHarian[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" disabled>
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="keteranganUangHarian[]">
                        </td>
                        <td class="border-x border-base-content">
                            <button name="hapusBiayaUangHarian" 
                                class="btn btn-error btn-xs" type="button">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `)
            })

            $('#biayaUangHarian').on('click', 'button[name="hapusBiayaUangHarian"]', function() {
                $(this).parent().parent().remove()
            })

            $('#tambahBiayaPenginapan').click(function() {

                $('#biayaPenginapan').append(`
                    <tr>
                        <td class="border-x border-base-content"></td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered" name="frekuensiPenginapan[]"> Hari x
                            <input type="text" class="input input-sm input-bordered nominal" name="nilaiPenginapan[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" disabled>
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="keteranganPenginapan[]">
                        </td>
                        <td class="border-x border-base-content">
                            <button name="hapusBiayaPenginapan" 
                                class="btn btn-error btn-xs" type="button">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `)
            })

            $('#biayaPenginapan').on('click', 'button[name="hapusBiayaPenginapan"]', function() {
                $(this).parent().parent().remove()
            })

            $('#tambahUangRepresentatif').click(function() {

                $('#uangRepresentatif').append(`
                    <tr>
                        <td class="border-x border-base-content"></td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered" name="frekuensiRepresentatif[]"> Hari x
                            <input type="text" class="input input-sm input-bordered nominal" name="nilaiRepresentatif[]">
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" disabled>
                        </td>
                        <td class="border-x border-base-content">
                            <input type="text" class="input input-sm input-bordered w-full max-w-xs" name="keteranganRepresentatif[]">
                        </td>
                        <td class="border-x border-base-content">
                            <button name="hapusUangRepresentatif" 
                                class="btn btn-error btn-xs" type="button">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `)
            })

            $('#uangRepresentatif').on('click', 'button[name="hapusUangRepresentatif"]', function() {
                $(this).parent().parent().remove()
            })
        })
    </script>

    <script>
        $(document).ready(function() {
            $('.nominal').each(function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            })
            $('.nominal').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            });

            $('#biayaAngkutan').on('input', 'input[name="nilaiBiayaAngkutan[]"]', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            })

            $('#biayaTransportasiLain').on('input', 'input[name="nilaiBiayaTransportasiLain[]"]', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            })

            $('#biayaUangHarian').on('input', 'input[name="nilaiUangHarian[]"]', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            })

            $('#biayaPenginapan').on('input', 'input[name="nilaiPenginapan[]"]', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            })

            $('#uangRepresentatif').on('input', 'input[name="nilaiRepresentatif[]"]', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            })

        });
    </script>
@endsection
