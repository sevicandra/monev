@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Referensi Rekening</h1>
    </div>
    <div class="px-4">
        <form action="" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">NIK/NIP/NPWP:</span>
                </label>
                <input type="text" name="kode"
                    class="input input-sm input-bordered  w-full max-w-xs @error('kode') input-error @enderror"
                    value="{{ $data->kode }}" />
                <label class="label">
                    @error('kode')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama Pemilik Rekening:</span>
                </label>
                <input type="text" name="nama"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nama') input-error @enderror"
                    value="{{ $data->nama }}" />
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
                    class="input input-sm input-bordered w-full max-w-xs @error('norek') input-error @enderror"
                    value="{{ $data->norek }}" />
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
                <select name="bank" id="bank"
                    class="select select-sm select-bordered  w-full max-w-xs @error('bank') select-error @enderror"
                    value="{{ $data->bank }}">
                    <option value="Bank Negara Indonesia" @if ($data->bank === 'Bank Negara Indonesia') selected @endif>Bank Negara
                        Indonesia</option>
                    <option value="Bank Rakyat Indonesia" @if ($data->bank === 'Bank Rakyat Indonesia') selected @endif>Bank Rakyat
                        Indonesia</option>
                    <option value="Bank Mandiri" @if ($data->bank === 'Bank Mandiri') selected @endif>Bank Mandiri</option>
                    <option value="Bank Syariah Indonesia" @if ($data->bank === 'Bank Syariah Indonesia') selected @endif>Bank
                        Syariah Indonesia</option>
                    <option value="Other" @if ($data->bank === 'Other') selected @endif>Other</option>
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
                class="form-control w-full max-w-xs @if ($data->bank === 'Other') selected @else hidden @endif">
                <label class="label">
                    <span class="label-text">Nomor Rekening:</span>
                </label>
                <input type="text" name="otherBank"
                    class="input input-sm input-bordered w-full max-w-xs @error('otherBank') input-error @enderror"
                    value="{{ $data->otherbank }}" placeholder="Input Other Bank Name" />
                <label class="label">
                    @error('otherBank')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/referensi-rekening" class="btn btn-sm btn-accent">Batal</a>
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
@endsection
