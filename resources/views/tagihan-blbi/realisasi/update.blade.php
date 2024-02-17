@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Input Nilai Realisasi</h1>
    </div>
    <div class="px-4">
        <form action="/tagihan-blbi/realisasi/{{ $data->id }}" method="post" autocomplete="off" id="inputRealisasi">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Realisasi (Bruto):</span>
                </label>
                <input type="text" name="realisasi" id="realisasi"
                    class="input input-sm input-bordered  w-full max-w-xs @error('realisasi') input-error @enderror"
                    value="{{ $data->realisasi }}" pattern="[0-9,.]*" />
                <label class="label">
                    @error('realisasi')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <a href="/tagihan-blbi/{{ $data->tagihan->id }}/realisasi" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('foot')
    <script>
        $(document).ready(function() {
            let value = $('#realisasi').val()
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $('#realisasi').val(value);
            $('#realisasi').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, ',');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });
            $("#inputRealisasi").submit(function(event) {
                event.preventDefault();
                var inputValue = $("#realisasi").val();
                var sanitizedValue = inputValue.replace(/\./g, "");
                $("#realisasi").val(sanitizedValue);
                this.submit();
            });
        });
    </script>
@endsection
