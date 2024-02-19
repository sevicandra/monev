@extends('layout.main')
@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Tagihan</h1>
    </div>
    <div class="px-4">
        <form id="inputForm" action="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn/{{ $data->id }}" method="post"
            autocomplete="off">
            @csrf
            @method('PATCH')
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Nomor Faktur:</span>
                </label>
                <input type="text" name="nomorfaktur"
                    class="input input-sm input-bordered w-full max-w-xs @error('nomorfaktur') input-error @enderror"
                    value="{{ $data->nomorfaktur }}" />
                <label class="label">
                    @error('nomorfaktur')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tanggal Faktur:</span>
                </label>
                <input type="date" name="tanggalfaktur"
                    class="input input-sm input-bordered w-full max-w-xs @error('tanggalfaktur') input-error @enderror"
                    value="{{ $data->tanggalfaktur }}" />
                <label class="label">
                    @error('tanggalfaktur')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Tarif:</span>
                </label>
                <select name="tarif"
                    class="select select-sm select-bordered w-full max-w-xs @error('objek') select-error @enderror">
                    <option value="0.11">11%</option>
                    <option value="0.01">1%</option>
                </select>
                <label class="label">
                    @error('tarif')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Dasar Pengenaan Pajak:</span>
                </label>
                <input id="dpp" type="text" name="ppn"
                    class="input input-sm input-bordered w-full max-w-xs @error('ppn') input-error @enderror"
                    value="{{ $data->ppn }}" />
                <label class="label">
                    @error('ppn')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            @if ($tagihan->jnstagihan === '0')
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">NTPN:</span>
                    </label>
                    <input type="text" name="ntpn"
                        class="input input-sm input-bordered w-full max-w-xs @error('ntpn') input-error @enderror"
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
                        <span class="label-text">Tanggal NTPN:</span>
                    </label>
                    <input type="date" name="tanggalntpn"
                        class="input input-sm input-bordered w-full max-w-xs @error('tanggalntpn') input-error @enderror"
                        value="{{ $data->tanggalntpn }}" />
                    <label class="label">
                        @error('tanggalntpn')
                            <span class="label-text-alt text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </label>
                </div>
            @endif
            <div>
                <a href="/bendahara/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/ppn"
                    class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            let value = $('#dpp').val()
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $('#dpp').val(value);
            $('#dpp').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, ',');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });
            $("#inputForm").submit(function(event) {
                event.preventDefault();
                var inputValue = $("#dpp").val();
                var sanitizedValue = inputValue.replace(/\./g, "");
                $("#dpp").val(sanitizedValue);
                this.submit();
            });
        });
    </script>
@endsection