@extends('layout.main')

@section('content')
    <div class="bg-primary p-4">
        <h1 class="text-xl text-primary-content">Riwayat</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between">
        <div class="">
            <a href="/monitoring-tagihan" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 gap-2 overflow-y-auto">
        <x-riwayat>
            @foreach ($data as $item)
                <tr>
                    <x-table.body.column class="border text-center">{{ $loop->iteration }}</x-table.body.column>
                    <x-table.body.column class="border">{{ indonesiaDate($item->created_at) }}</x-table.body.column>
                    <x-table.body.column class="border">{{ $item->User }}</x-table.body.column>
                    <x-table.body.column class="border text-center">{{ $item->action }}</x-table.body.column>
                    <x-table.body.column class="border text-center">
                        @if ($item->catatan)
                            <button class="btn btn-xs" onclick="catatan_{{ $loop->iteration }}.showModal()">catatan</button>
                        @endif
                    </x-table.body.column>
                </tr>
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
                    </dialog>
                @endif
            @endforeach
        </x-riwayat>
    </div>
@endsection
