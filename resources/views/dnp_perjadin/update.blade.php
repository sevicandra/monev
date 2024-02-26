@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah DNP Perjadin</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nama:</span>
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
                    <span class="label-text">NIP/NIK/NRP/DLL:</span>
                </label>
                <input type="text" name="nip"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nip') input-error @enderror"
                    value="{{ $data->nip }}" />
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
                    <span class="label-text">Unit Kerja:</span>
                </label>
                <input type="text" name="unit"
                    class="input input-sm input-bordered  w-full max-w-xs @error('unit') input-error @enderror"
                    value="{{ $data->unit }}" />
                <label class="label">
                    @error('unit')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Surat Tugas:</span>
                </label>
                <input type="text" name="st"
                    class="input input-sm input-bordered  w-full max-w-xs @error('st') input-error @enderror"
                    value="{{ $data->st }}" />
                <label class="label">
                    @error('st')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Lokasi (Asal - Tujuan):</span>
                </label>
                <input type="text" name="lokasi"
                    class="input input-sm input-bordered  w-full max-w-xs @error('lokasi') input-error @enderror"
                    value="{{ $data->lokasi }}" />
                <label class="label">
                    @error('lokasi')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Durasi (Mulai - Selesai):</span>
                </label>
                <input type="text" name="durasi"
                    class="input input-sm input-bordered  w-full max-w-xs @error('durasi') input-error @enderror"
                    value="{{ $data->durasi }}" />
                <label class="label">
                    @error('durasi')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Rekening:</span>
                </label>
                <input type="text" name="rekening"
                    class="input input-sm input-bordered  w-full max-w-xs @error('rekening') input-error @enderror"
                    value="{{ $data->norek }}" />
                <label class="label">
                    @error('rekening')
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
                <input type="text" name="namarekening"
                    class="input input-sm input-bordered  w-full max-w-xs @error('namarekening') input-error @enderror"
                    value="{{ $data->namarek }}" />
                <label class="label">
                    @error('namarekening')
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
                    value="{{ $data->bank }}" />
                <label class="label">
                    @error('bank')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>

            <div>
                <a href="{{ $base_url }}/{{ $tagihan->id }}/dnp-perjadin" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
