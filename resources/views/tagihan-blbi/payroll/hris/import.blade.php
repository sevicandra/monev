@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Impor Payroll</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/tagihan-blbi/{{ $tagihan->id }}/payroll" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
        <div>
            <form action="" method="get" autocomplete="off">
                <div class="join">
                    <input type="text" name="nip" class="input input-sm input-bordered join-item"
                        placeholder="NIP Penerima">
                    <div class="indicator">
                        <button class="btn join-item btn-sm btn-neutral">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-payroll.import>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="text-center border">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">
                        <input id="nama_{{ $item->IdpegawaiRekening }}" type="text"
                            value="{{ $item->NamaPemilikRekening }}" class="input input-sm w-min-content input-ghost"
                            readonly="readonly" disabled>
                    </x-table.body.column>
                    <x-table.body.column class="border">
                        <input id="norek_{{ $item->IdpegawaiRekening }}" type="text" value="{{ $item->NomorRekening }}"
                            class="input input-sm w-min-content input-ghost" readonly="readonly" disabled>
                    </x-table.body.column>
                    <x-table.body.column class="border">
                        <input id="bank_{{ $item->IdpegawaiRekening }}" type="text" value="{{ $item->NamaBank }}"
                            class="input input-sm w-min-content input-ghost" readonly="readonly" disabled>
                    </x-table.body.column>
                    <x-table.body.column class="border">
                        <div class="join">
                            <button id="{{ $item->IdpegawaiRekening }}" type="button"
                                class="import-btn btn btn-xs btn-outline btn-neutral join-item">Pilih</button>
                        </div>
                    </x-table.body.column>
                </tr>
            @endforeach
        </x-payroll.import>
    </div>
@endsection

@section('foot')
    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" id="import-btn-close">✕</button>
            </form>
            <form id="inputPayroll" action="/tagihan-blbi/{{ $tagihan->id }}/payroll/import" method="post"
                autocomplete="off">
                @csrf
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Nama Pemilik Rekening:</span>
                    </label>
                    <input type="text" name="nama" id="formnama" readonly required
                        class="input input-sm input-bordered  w-full max-w-xs @error('nama') input-error @enderror"
                        value="{{ old('nama') }}" />
                    <label class="label">
                        @error('nama')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Nomor Rekening:</span>
                    </label>
                    <input type="text" name="norek" id="formnorek" readonly required
                        class="input input-sm input-bordered  w-full max-w-xs @error('norek') input-error @enderror"
                        value="{{ old('norek') }}" />
                    <label class="label">
                        @error('norek')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Nomor Rekening:</span>
                    </label>
                    <input type="text" name="bank" id="formbank" readonly required
                        class="input input-sm input-bordered  w-full max-w-xs @error('bank') input-error @enderror"
                        value="{{ old('bank') }}" />
                    <label class="label">
                        @error('bank')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Bruto:</span>
                    </label>
                    <input type="text" name="bruto" id="bruto"
                        class="input input-sm input-bordered  w-full max-w-xs @error('bruto') input-error @enderror"
                        value="{{ old('bruto') }}" />
                    <label class="label">
                        @error('bruto')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Potongan Pajak:</span>
                    </label>
                    <input type="text" name="pajak" id="pajak"
                        class="input input-sm input-bordered  w-full max-w-xs @error('pajak') input-error @enderror"
                        value="{{ old('pajak') }}" />
                    <label class="label">
                        @error('pajak')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Biaya Administrasi:</span>
                    </label>
                    <input type="text" name="admin" id="admin"
                        class="input input-sm input-bordered  w-full max-w-xs @error('admin') input-error @enderror"
                        value="{{ old('admin') }}" />
                    <label class="label">
                        @error('admin')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>
    <script>
        $(document).ready(function() {
            $(".import-btn").click(function() {
                my_modal_3.showModal()
                const id = $(this).attr('id')
                const formnama = $("#nama_" + id).val()
                const formnorek = $("#norek_" + id).val()
                const formbank = $("#bank_" + id).val()
                $("#formnama").attr('value', formnama)
                $("#formnorek").attr('value', formnorek)
                $("#formbank").attr('value', formbank)
                $("#importModal").modal('toggle');
            });
            $("#import-btn-close").click(function() {
                $("#formnama").attr('value', '')
                $("#formnorek").attr('value', '')
                $("#formbank").attr('value', '')
                $("#importModal").modal('toggle');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let valueBruto = $('#bruto').val()
            valueBruto = valueBruto.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $('#bruto').val(valueBruto);

            let valuePajak = $('#pajak').val()
            valuePajak = valuePajak.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $('#pajak').val(valuePajak);

            let valueAdmin = $('#admin').val()
            valueAdmin = valueAdmin.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $('#admin').val(valueAdmin);




            $('#bruto').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, ',');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });

            $('#pajak').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, ',');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });

            $('#admin').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, ',');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });

            $("#inputPayroll").submit(function(event) {
                event.preventDefault();
                var inputValueBruto = $("#bruto").val();
                var sanitizedValueBruto = inputValueBruto.replace(/\./g, "");
                $("#bruto").val(sanitizedValueBruto);

                var inputValuePajak = $("#pajak").val();
                var sanitizedValuePajak = inputValuePajak.replace(/\./g, "");
                $("#pajak").val(sanitizedValuePajak);

                var inputValueAdmin = $("#admin").val();
                var sanitizedValueAdmin = inputValueAdmin.replace(/\./g, "");
                $("#admin").val(sanitizedValueAdmin);

                this.submit();
            });
        });
    </script>
@endsection
