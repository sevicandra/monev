@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah DNP Perjadin</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama:</span>
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
                    <span class="label-text">NIP/NIK/NRP/DLL:</span>
                </label>
                <input type="text" name="nip"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nip') input-error @enderror"
                    value="{{ old('nip') }}" />
                <label class="label">
                    @error('nip')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Dasar Pembayaran:</span>
                </label>
                <input type="text" name="dasar"
                    class="input input-sm input-bordered  w-full max-w-xs @error('dasar') input-error @enderror"
                    value="{{ old('dasar') }}" />
                <label class="label">
                    @error('dasar')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Jabatan:</span>
                </label>
                <input type="text" name="jabatan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('jabatan') input-error @enderror"
                    value="{{ old('jabatan') }}" />
                <label class="label">
                    @error('jabatan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Golongan:</span>
                </label>
                <input type="text" name="gol"
                    class="input input-sm input-bordered  w-full max-w-xs @error('gol') input-error @enderror"
                    value="{{ old('gol') }}" />
                <label class="label">
                    @error('gol')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">NPWP:</span>
                </label>
                <input type="text" name="npwp"
                    class="input input-sm input-bordered  w-full max-w-xs @error('npwp') input-error @enderror"
                    value="{{ old('npwp') }}" />
                <label class="label">
                    @error('npwp')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Frekuensi:</span>
                </label>
                <input type="text" name="frekuensi"
                    class="input input-sm input-bordered  w-full max-w-xs @error('frekuensi') input-error @enderror"
                    value="{{ old('frekuensi') }}" />
                <label class="label">
                    @error('frekuensi')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nilai Satuan:</span>
                </label>
                <input type="text" name="nilai"
                    class="input input-sm input-bordered nominal w-full max-w-xs @error('nilai') input-error @enderror"
                    value="{{ old('nilai') }}" />
                <label class="label">
                    @error('nilai')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Pajak:</span>
                </label>
                <input type="text" name="pajak"
                    class="input input-sm input-bordered nominal w-full max-w-xs @error('pajak') input-error @enderror"
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
                    <span class="label-text">Nama Rekening:</span>
                </label>
                <input type="text" name="namarek"
                    class="input input-sm input-bordered  w-full max-w-xs @error('namarek') input-error @enderror"
                    value="{{ old('namarek') }}" />
                <label class="label">
                    @error('namarek')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>

            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Bank:</span>
                </label>
                <input type="text" name="bank"
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

            <div>
                <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-honorarium" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('foot')
    <script>
        $(document).ready(function() {
            $('.nominal').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, '.');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                $(this).val(value);
            });
        });
    </script>
@endsection
