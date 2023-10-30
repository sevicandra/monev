@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Impor Payroll</h1>
    </div>
    <div class="row">
        <div class="col">
            @include('layout.flashmessage')
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-7">
            <a href="/verifikasi/{{ $tagihan->id }}/payroll" class="btn btn-sm btn-outline-secondary mt-1 mb-1 ml-2">Sebelumnya</a>
        </div>
        <div class="col-lg-5">
            <form action="" method="get" autocomplete="off">
            <div class="input-group">
                <input type="text" name="nip" class="form-control" placeholder="NIP Pegawai">
                <button class="btn btn-sm btn-outline-secondary" type="submit">Cari</button>
            </div>
            </form>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Nama Pemilik Rekening</th>
                            <th>Nomor Rekening</th>
                            <th>Nama Bank</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td id="nama_{{ $item->IdpegawaiRekening }}">{{  $item->NamaPemilikRekening  }}</td>
                                <td id="norek_{{ $item->IdpegawaiRekening }}">{{  $item->NomorRekening  }}</td>
                                <td id="bank_{{ $item->IdpegawaiRekening }}">{{  $item->NamaBank  }}</td>
                                <td class="pb-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="{{ $item->IdpegawaiRekening }}" type="button" class="import-btn btn btn-sm btn-outline-secondary pt-0 pb-0">Pilih</button>
                                    </div>
                                </td>
                            </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            
        </div>
    </div>

</main>
@endsection

@section('foot')
<div class="modal fade" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <form action="/verifikasi/{{ $tagihan->id }}/payroll/import" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-2">
                            <label for="">Nama Pemilik Rekening:</label>
                            <input required id="formnama" type="text" name="nama" class="form-control" value="" readonly="readonly">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Nomor Rekening:</label>
                            <input required id="formnorek" type="text" name="norek" class="form-control" value="" readonly="readonly">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Nama Bank:</label>
                            <input required id="formbank" type="text" name="bank" class="form-control" value="" readonly="readonly">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Bruto:</label>
                            <input required type="text" name="bruto" class="form-control @error('bruto') is-invalid @enderror" value="{{ old('bruto') }}">
                            <div class="invalid-feedback">
                                @error('bruto')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Potongan Pajak:</label>
                            <input required type="text" name="pajak" class="form-control @error('pajak') is-invalid @enderror" value="{{ old('pajak') }}">
                            <div class="invalid-feedback">
                                @error('pajak')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Biaya Administrasi:</label>
                            <input required type="text" name="admin" class="form-control @error('admin') is-invalid @enderror" value="{{ old('admin') }}">
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
                            <button type="button" class="import-btn-close btn btn-sm btn-outline-secondary">Batal</button>
                            <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".import-btn").click(function(){
            const id = $(this).attr('id')
            const formnama = $("#nama_"+id).text()
            const formnorek = $("#norek_"+id).text()
            const formbank = $("#bank_"+id).text()
            $("#formnama").attr('value', formnama)
            $("#formnorek").attr('value', formnorek)
            $("#formbank").attr('value', formbank)
            $("#importModal").modal('toggle');
        });
        $(".import-btn-close").click(function(){
            $("#formnama").attr('value', '')
            $("#formnorek").attr('value', '')
            $("#formbank").attr('value', '')
            $("#importModal").modal('toggle');
        });
    });
</script>
@endsection