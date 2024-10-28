@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Input Nilai Realisasi</h1>
    </div>
    <div class="px-4">
        <form action="/tagihan/realisasi/{{ $data->id }}" method="post" autocomplete="off" id="inputRealisasi">
            @method('PATCH')
            @csrf
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Realisasi (Bruto):</span>
                </label>
                <input type="text" name="realisasi" id="realisasi"
                    class="input input-sm input-bordered  w-full max-w-xs @error('realisasi') input-error @enderror"
                    value="{{ $data->realisasi }}" pattern="-?[0-9,.]*" />
                <label class="label">
                    @error('realisasi')
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </label>
            </div>
            <div class="form-group">
                <a href="/tagihan/{{ $data->tagihan->id }}/realisasi" class="btn btn-sm btn-accent">Batal</a>
                <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@section('foot')
<script>
    $(document).ready(function() {
        let value = $('#realisasi').val();
        
        // Tambahkan format titik ribuan saat halaman dimuat dan izinkan tanda minus di awal
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        $('#realisasi').val(value);

        $('#realisasi').on('input', function() {
            let value = $(this).val();

            // Izinkan angka, tanda minus di awal, koma, dan titik saja
            value = value.replace(/[^0-9,.-]/g, '');       // Hapus karakter tidak valid
            value = value.replace(/(?!^)-/g, '');           // Hapus tanda minus selain di awal
            value = value.replace(/,+/g, ',');              // Hanya izinkan satu koma
            value = value.replace(/\./g, '');               // Hapus semua titik
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik ribuan
            
            $(this).val(value);
        });

        $("#inputRealisasi").submit(function(event) {
            event.preventDefault();

            // Hapus titik sebelum dikirim ke server
            var inputValue = $("#realisasi").val();
            var sanitizedValue = inputValue.replace(/\./g, "");
            $("#realisasi").val(sanitizedValue);

            this.submit();
        });
    });
</script>

@endsection
