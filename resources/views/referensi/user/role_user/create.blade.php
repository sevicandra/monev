@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Tambah Role {{ $user->nama }}</h1>
    </div>
    <div class="">
        @include('layout.flashmessage')
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div>
            <a href="/role-user/{{ $user->id }}" class="btn btn-sm btn-neutral">Kembali</a>
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
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i++ }}</td>
                        <td class="border border-base-content">{{ $item->koderole }}</td>
                        <td class="border border-base-content">{{ $item->role }}</td>
                        <td class="border border-base-content text-center">
                            <div class="join">
                                <form action="/role-user/{{ $item->id }}/{{ $user->id }}" method="post">
                                    @csrf
                                    <button class="btn btn-xs btn-outline btn-neutral"
                                        onclick="return confirm('Apakah Anda yakin akan menambah role ini ini?');">Pilih</button>
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
