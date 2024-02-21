@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Tagihan</h1>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor Tagihan (5 digit):</span>
                </label>
                <input type="text" name="notagihan"
                    class="input input-sm input-bordered  w-full max-w-xs @error('notagihan') input-error @enderror"
                    value="{{ $data->notagihan }}" />
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
                    placeholder="dd-mm-yyyy" value="{{ $data->tgltagihan }}" />
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
                    >{{ $data->uraian }}</textarea>
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
                    <span class="label-text">Jenis tagihan:</span>
                </label>
                <select type="text" name="jnstagihan"
                    class="select select-sm select-bordered w-full max-w-xs @error('jnstagihan') select-error @enderror">
                    <option value="0" @if ($data->jnstagihan == 0) selected @endif>SPBy</option>
                    <option value="1" @if ($data->jnstagihan == 1) selected @endif>SPP</option>
                    <option value="2" @if ($data->jnstagihan == 2) selected @endif>KKP</option>
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
                    <span class="label-text">Unit:</span>
                </label>
                <select type="text" name="kodeunit"
                    class="select select-sm select-bordered w-full max-w-xs @error('kodeunit') select-error @enderror">
                    @foreach ($unit as $item)
                        <option value="{{ $item->kodeunit }}" @if ($data->kodeunit === $item->kodeunit) selected @endif>
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
                    <span class="label-text">PPK:</span>
                </label>
                <select type="text" name="ppk"
                    class="select select-sm select-bordered w-full max-w-xs @error('ppk') select-error @enderror">
                    @foreach ($ppk as $item)
                        <option value="{{ $item->nip }}" @if ($data->ppk_id === $item->nip) selected @endif>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('ppk')
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
                        <option value="{{ $item->kodedokumen }}" @if ($data->kodedokumen === $item->kodedokumen) selected @endif>
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
            <div class="form-group">
                <a href="/tagihan-blbi" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
