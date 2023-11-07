@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Input PPh</h1>
    </div>

    <div class="px-4">
        <form id="inputForm" action="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph" method="post"
            autocomplete="off">
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Objek Pajak:</span>
                </label>
                <select type="text" name="objek"
                    class="select select-sm select-bordered w-full max-w-xs @error('objek') select-error @enderror">
                    @foreach ($objekpajak as $obj)
                        <option value="{{ $obj->kode }}" @if (old('objek') === $obj->kode) selected @endif>
                            {{ $obj->kode }} / {{ $obj->nama }} - {{ $obj->jenis }}
                        </option>
                    @endforeach
                </select>
                <label class="label">
                    @error('objek')
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
                <input id="dpp" type="text" name="pph"
                    class="input input-sm input-bordered  w-full max-w-xs @error('pph') input-error @enderror"
                    value="{{ old('pph') }}" />
                <label class="label">
                    @error('pph')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div>
                <a href="/verifikasi/{{ $tagihan->id }}/rekanan/{{ $rekanan->id }}/pph"
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
