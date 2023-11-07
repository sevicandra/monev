@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Detail Akun</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col lg:flex-row px-4 gap-2 justify-between">
        <div class="lg:basis-5/12 flex gap-2">
            <a href="/tagihan/{{ $data->id }}/realisasi" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
        <div class="lg:basis-7/12 overflow-hidden max-w-full shrink">
            <form action="" method="get" autocomplete="off">
                <div class="join flex max-w-full justify-end">
                    <input type="text" name="program" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('program') }}" placeholder="Program">
                    <input type="text" name="kegiatan" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('kegiatan') }}" placeholder="Kegiatan">
                    <input type="text" name="kro" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('kro') }}" placeholder="KRO">
                    <input type="text" name="ro" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('ro') }}" placeholder="RO">
                    <input type="text" name="komponen" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('komponen') }}" placeholder="Komponen">
                    <input type="text" name="subkomponen" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('subkomponen') }}" placeholder="Subkomponen">
                    <input type="text" name="akun" class="input input-sm input-bordered join-item w-full"
                        value="{{ request('akun') }}" placeholder="Akun">
                    <button class="btn btn-sm btn-outline join-item" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Program</th>
                    <th class="border border-base-content">Kegiatan</th>
                    <th class="border border-base-content">KRO</th>
                    <th class="border border-base-content">RO</th>
                    <th class="border border-base-content">Komponen</th>
                    <th class="border border-base-content">Subkomponen</th>
                    <th class="border border-base-content">Akun</th>
                    <th class="border border-base-content">Pagu</th>
                    <th class="border border-base-content">Realisasi</th>
                    <th class="border border-base-content">Sisa Anggaran</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($pagu as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i++ }}</td>
                        <td class="border border-base-content text-center">{{ $item->program }}</td>
                        <td class="border border-base-content text-center">{{ $item->kegiatan }}</td>
                        <td class="border border-base-content text-center">{{ $item->kro }}</td>
                        <td class="border border-base-content text-center">{{ $item->ro }}</td>
                        <td class="border border-base-content text-center">{{ $item->komponen }}</td>
                        <td class="border border-base-content text-center">{{ $item->subkomponen }}</td>
                        <td class="border border-base-content text-center">{{ $item->akun }}</td>
                        <td class="border border-base-content text-right">Rp{{ number_format($item->anggaran, 2, ',', '.') }}</td>
                        <td class="border border-base-content text-right">
                            Rp{{ number_format($item->realisasi->sum('realisasi') - $item->sspb->sum('nominal_sspb'), 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content text-right">
                            Rp{{ number_format($item->anggaran - $item->realisasi->sum('realisasi') + $item->sspb->sum('nominal_sspb'), 2, ',', '.') }}
                        </td>
                        <td class="border border-base-content">
                                <form action="/tagihan/{{ $data->id }}/realisasi/{{ $item->id }}" method="post">
                                    @csrf
                                    <button class="btn btn-xs btn-outline btn-neutral">Pilih</button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('pagination')
    {{ $pagu->links() }}
@endsection
