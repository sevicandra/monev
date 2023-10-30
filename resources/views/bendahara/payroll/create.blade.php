@extends('layout.main')

@section('content')
    <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Payroll</h1>
        </div>

        <form action="" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-2">
                        <label for="">Nama Pemilik Rekening:</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        <div class="invalid-feedback">
                            @error('nama')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Nomor Rekening:</label>
                        <input type="text" name="norek" class="form-control @error('norek') is-invalid @enderror" value="{{ old('norek') }}">
                        <div class="invalid-feedback">
                            @error('norek')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Nama Bank:</label>
                        <select id="bank" class="form-select form-select-sm mb-3" name="bank">
                            <option value="Bank Negara Indonesia" @if (old('bank') === 'Bank Negara Indonesia') selected @endif>Bank Negara Indonesia</option>
                            <option value="Bank Rakyat Indonesia" @if (old('bank') === 'Bank Rakyat Indonesia') selected @endif>Bank Rakyat Indonesia</option>
                            <option value="Bank Mandiri" @if (old('bank') === 'Bank Mandiri') selected @endif>Bank Mandiri</option>
                            <option value="Bank Syariah Indonesia" @if (old('bank') === 'Bank Syariah Indonesia') selected @endif>Bank Syariah Indonesia</option>
                            <option value="Other" @if (old('bank') === 'Other') selected @endif>Other</option>
                        </select>
                        <div class="invalid-feedback">
                            @error('bank')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div id="otherBank" class="form-group mb-2" style="display: @if (old('bank') === 'Other') selected @else none @endif">
                        <input  placeholder="Input Other Bank Name" type="text" name="otherBank" class="form-control @error('otherBank') is-invalid @enderror" value="{{ old('otherBank') }}">
                        <div class="invalid-feedback">
                            @error('otherBank')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Bruto:</label>
                        <input type="text" name="bruto" class="form-control @error('bruto') is-invalid @enderror" value="{{ old('bruto') }}">
                        <div class="invalid-feedback">
                            @error('bruto')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Potongan Pajak:</label>
                        <input type="text" name="pajak" class="form-control @error('pajak') is-invalid @enderror" value="{{ old('pajak') }}">
                        <div class="invalid-feedback">
                            @error('pajak')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Biaya Administrasi:</label>
                        <input type="text" name="admin" class="form-control @error('admin') is-invalid @enderror" value="{{ old('admin') }}">
                        <div class="invalid-feedback">
                            @error('admin')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="form-group">
                        <a href="/bendahara/{{ $tagihan->id }}/payroll" class="btn btn-sm btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </main>
@endsection

@section('foot')
<script>
    document.getElementById("bank").addEventListener("change", function() {
        var otherBankInput = document.getElementById("otherBank");
        if (this.value === "Other") {
            otherBankInput.style.display = "block";
        } else {
            otherBankInput.style.display = "none";
        }
    });
</script>
@endsection