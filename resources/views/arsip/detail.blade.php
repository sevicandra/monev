@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Riwayat</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/arsip" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <table class="table border-collapse w-full">
            <thead class="text-center">
                <tr class="align-middle">
                    <th class="border border-base-content">No</th>
                    <th class="border border-base-content">Tanggal</th>
                    <th class="border border-base-content">Nama</th>
                    <th class="border border-base-content">Action</th>
                    <th class="border border-base-content">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td class="border border-base-content text-center">{{ $i }}</td>
                        <td class="border border-base-content">{{ indonesiaDate($item->created_at) }}</td>
                        <td class="border border-base-content">{{ $item->User }}</td>
                        <td class="border border-base-content text-center">{{ $item->action }}</td>
                        <td class="border border-base-content text-center">
                            @if ($item->catatan)
                                <button class="btn btn-xs"
                                    onclick="catatan_{{ $loop->iteration }}.showModal()">catatan</button>
                            @endif
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @if ($item->catatan)
                        <dialog id="catatan_{{ $loop->iteration }}" class="modal">
                            <div
                                class="modal-box w-11/12 max-w-5xl max-h-11/12 grid grid-rows-[auto_auto_1fr] overflow-hidden gap-2 p-0">
                                <div class="flex justify-end glass p-2">
                                    <button class="btn btn-sm btn-ghost"
                                        onclick="catatan_{{ $loop->iteration }}.close()">✕</button>
                                </div>
                                <div class="p-2 flex flex-col gap-2">
                                    <h1>
                                        {{ indonesiaDate($item->created_at) }} {{ $item->created_at->format('H:i:s') }}
                                    </h1>
                                    <hr>
                                </div>
                                <div class="rich-text overflow-y-auto px-4 py-2">
                                    {!! $item->catatan !!}
                                </div>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
