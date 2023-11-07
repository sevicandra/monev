@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Payroll</h1>
    </div>
    <div class="px-4">
        <form action="" method="post" autocomplete="off" id="inputPayroll">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama Pemilik Rekening:</span>
                </label>
                <input type="text" name="nama"
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
                <input type="text" name="norek"
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
                    <span class="label-text">Nama Bank:</span>
                </label>
                <select id="bank" type="text" name="bank"
                    class="select select-sm select-bordered w-full max-w-xs @error('bank') select-error @enderror">
                    <option value="Bank Negara Indonesia" @if (old('bank') === 'Bank Negara Indonesia') selected @endif>Bank Negara
                        Indonesia</option>
                    <option value="Bank Rakyat Indonesia" @if (old('bank') === 'Bank Rakyat Indonesia') selected @endif>Bank Rakyat
                        Indonesia</option>
                    <option value="Bank Mandiri" @if (old('bank') === 'Bank Mandiri') selected @endif>Bank Mandiri</option>
                    <option value="Bank Syariah Indonesia" @if (old('bank') === 'Bank Syariah Indonesia') selected @endif>Bank Syariah
                        Indonesia</option>
                    <option value="Other" @if (old('bank') === 'Other') selected @endif>Other</option>
                </select>
                <label class="label">
                    @error('bank')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div id="otherBank"
                class="form-control w-full max-w-xs @if (old('bank') === 'Other') selected @else hidden @endif">
                <label class="label">
                    <span class="label-text">Nomor Rekening:</span>
                </label>
                <input type="text" name="otherBank"
                    class="input input-sm input-bordered w-full max-w-xs @error('otherBank') input-error @enderror"
                    value="{{ old('otherBank') }}" placeholder="Input Other Bank Name" />
                <label class="label">
                    @error('otherBank')
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
                <a href="/verifikasi/{{ $tagihan->id }}/payroll" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('foot')
    <script>
        $(document).ready(function() {
            $('#bank').on('change', function() {
                var selectedValue = $(this).val();
                if ($(this).val() === "Other") {
                    $('#otherBank').removeClass('hidden');
                } else {
                    $('#otherBank').addClass('hidden');

                }
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
