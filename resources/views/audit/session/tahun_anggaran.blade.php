@extends('audit.layouts.index')
@section('content')
    <div class="">
        
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <form action="" method="post" autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tahun Anggaran:</span>
                </label>
                <select type="text" name="tahun"
                    class="select select-sm select-bordered w-full max-w-xs @error('tahun') select-error @enderror">
                    @foreach ($tahun as $item)
                        <option value="{{ $item->tahun }}" @if (session('tahun') === $item->tahun) selected @endif>
                            {{ $item->tahun }}</option>
                    @endforeach
                </select>
                <label class="label">
                    @error('tahun')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="{{ url()->current() === Str::before(url()->previous(), '?') ? '/audit' : url()->previous() }}" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
