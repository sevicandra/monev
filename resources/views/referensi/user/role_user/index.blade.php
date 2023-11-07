@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Role {{ $data->nama }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/user" class="btn btn-sm btn-neutral"> Kembali</a>
            <a href="/role-user/{{ $data->id }}/edit" class="btn btn-sm btn-neutral"> Tambah Data</a>
        </div>
        <div>

        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Kode Role</th>
                    <th class="border border-base-content">Role</th>
                    <th class="border border-base-content">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data->role()->get() as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i++ }}</td>
                        <td class="border border-base-content">{{ $item->koderole }}</td>
                        <td class="border border-base-content">{{ $item->role }}</td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <form action="/role-user/{{ $item->id }}/{{ $data->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-outline btn-error"
                                        onclick="return confirm('Apakah Anda yakin akan menghapus role ini?');">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @php
                    $i++;
                @endphp
            </tbody>
        </table>

    </div>
@endsection
