@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Ubah Detail Pengembalian</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="px-4">
        <form action="" method="post" autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nominal Pengembalian:</span>
                </label>
                <input type="text" name="nominal_sspb"
                    class="input input-sm input-bordered  w-full max-w-xs @error('nominal_sspb') input-error @enderror"
                    value="{{ $data->nominal_sspb }}" />
                <label class="label">
                    @error('nominal_sspb')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">NTPN:</span>
                </label>
                <input type="text" name="ntpn"
                    class="input input-sm input-bordered  w-full max-w-xs @error('ntpn') input-error @enderror"
                    value="{{ $data->ntpn }}" />
                <label class="label">
                    @error('ntpn')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tanggal Pengembalian:</span>
                </label>
                <input type="date" name="tanggal_sspb"
                    class="input input-sm input-bordered  w-full max-w-xs @error('tanggal_sspb') input-error @enderror"
                    value="{{ $data->tanggal_sspb }}" />
                <label class="label">
                    @error('tanggal_sspb')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <a href="/bendahara/{{ $tagihan->id }}/realisasi/{{ $realisasi->id }}/sspb" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
