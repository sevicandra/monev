@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Tagihan</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="/tagihan" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor Tagihan (5 digit):</span>
                </label>
                <input type="text" name="notagihan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('notagihan') input-error @enderror"
                    value="{{ old('notagihan') }}" />
                <label class="label">
                    @error('notagihan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tanggal Tagihan:</span>
                </label>
                <input type="date" name="tgltagihan"
                    class="input input-sm input-bordered w-full max-w-xs @error('tgltagihan') input-error @enderror"
                    placeholder="dd-mm-yyyy" value="{{ old('tgltagihan') }}" />
                <label class="label">
                    @error('tgltagihan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Uraian Tagihan:</span>
                </label>
                <textarea type="text" name="uraian" maxlength="255"
                    class="textarea textarea-sm textarea-bordered  w-full max-w-xs @error('uraian') textarea-error @enderror"
                    >{{ old('uraian') }}</textarea>
                <label class="label">
                    @error('uraian')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Unit:</span>
                </label>
                <select type="text" name="jnstagihan"
                    class="select select-sm select-bordered w-full max-w-xs @error('jnstagihan') select-error @enderror">
                    <option value="0" @if (old('jnstagihan') == 0) selected @endif>SPBy</option>
                    <option value="1" @if (old('jnstagihan') == 1) selected @endif>SPP</option>
                    <option value="2" @if (old('jnstagihan') == 2) selected @endif>KKP</option>
                </select>
                <label class="label">
                    @error('jnstagihan')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Jenis tagihan:</span>
                </label>
                <select type="text" name="kodeunit"
                    class="select select-sm select-bordered w-full max-w-xs @error('kodeunit') select-error @enderror">
                    @foreach ($unit as $item)
                        <option value="{{ $item->kodeunit }}" @if (old('kodeunit') === $item->kodeunit) selected @endif>
                            {{ $item->namaunit }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('kodeunit')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Jenis Dokumen:</span>
                </label>
                <select type="text" name="kodedokumen"
                    class="select select-sm select-bordered w-full max-w-xs @error('kodedokumen') select-error @enderror">
                    @foreach ($dokumen as $item)
                        <option value="{{ $item->kodedokumen }}" @if (old('kodedokumen') === $item->kodedokumen) selected @endif>
                            {{ $item->namadokumen }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('kodedokumen')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/tagihan" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
