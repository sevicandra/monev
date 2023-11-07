@extends('layout.main')

@section('content')

<div class="bg-primary p-4">
    <h1 class="text-xl text-primary-content">Update Pagu</h1>
</div>
<div class="px-4 gap-2 overflow-y-auto">
    <form id="inputPagu" action="/pagu/{{ $data->id }}" method="post" autocomplete="off">
        @csrf
        @method('PATCH')
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Program:</span>
            </label>
            <input type="text" name="program"
                class="input input-sm input-bordered  w-full max-w-xs @error('program') input-error @enderror"
                value="{{ $data->program }}" />
            <label class="label">
                @error('program')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Kegiatan:</span>
            </label>
            <input type="text" name="kegiatan"
                class="input input-sm input-bordered  w-full max-w-xs @error('kegiatan') input-error @enderror"
                value="{{ $data->kegiatan }}" />
            <label class="label">
                @error('kegiatan')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">KRO:</span>
            </label>
            <input type="text" name="kro"
                class="input input-sm input-bordered  w-full max-w-xs @error('kro') input-error @enderror"
                value="{{ $data->kro }}" />
            <label class="label">
                @error('kro')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">RO:</span>
            </label>
            <input type="text" name="ro"
                class="input input-sm input-bordered  w-full max-w-xs @error('ro') input-error @enderror"
                value="{{ $data->ro }}" />
            <label class="label">
                @error('ro')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Komponen:</span>
            </label>
            <input type="text" name="komponen"
                class="input input-sm input-bordered  w-full max-w-xs @error('komponen') input-error @enderror"
                value="{{ $data->komponen }}" />
            <label class="label">
                @error('komponen')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Sub Komponen:</span>
            </label>
            <input type="text" name="subkomponen"
                class="input input-sm input-bordered  w-full max-w-xs @error('subkomponen') input-error @enderror"
                value="{{ $data->subkomponen }}" />
            <label class="label">
                @error('subkomponen')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Akun:</span>
            </label>
            <input type="text" name="akun"
                class="input input-sm input-bordered  w-full max-w-xs @error('akun') input-error @enderror"
                value="{{ $data->akun }}" />
            <label class="label">
                @error('akun')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Anggaran:</span>
            </label>
            <input type="text" name="anggaran" id="anggaran"
                class="input input-sm input-bordered  w-full max-w-xs @error('anggaran') input-error @enderror"
                value="{{ $data->anggaran }}" />
            <label class="label">
                @error('anggaran')
                    <span class="label-text-alt text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </label>
        </div>
        <div>
            <a href="/pagu" class="btn btn-sm btn-accent">Batal</a>
            <button type="submit" class="btn btn-sm btn-accent">Simpan</button>
        </div>
    </form>
</div>
@endsection
@section('foot')
    <script>
        $(document).ready(function() {
            let value = $('#anggaran').val()
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $('#anggaran').val(value);
            $('#anggaran').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '');
                value = value.replace(/,+/g, ',');
                value = value.replace(/\./g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });
            $("#inputPagu").submit(function(event) {
                event.preventDefault();
                var inputValue = $("#anggaran").val();
                var sanitizedValue = inputValue.replace(/\./g, "");
                $("#anggaran").val(sanitizedValue);
                this.submit();
            });
        });
    </script>
@endsection