@extends('layout.main')

@section('content')
    <div class="bg-primary p-4 flex-none">
        <h1 class="text-xl text-primary-content">Riwayat</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between flex-none">
        <div class="">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
        <hr>
    </div>
    <div class="px-4 overflow-y-auto">
        <ul class="timeline timeline-snap-icon timeline-compact timeline-vertical">
            @foreach ($data as $item)
                <li>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end mb-10">
                        <time class="font-mono italic">{{ indonesiaDate($item->created_at) }}
                            {{ $item->created_at->format('H:i:s') }}</time>
                        <div class="text-lg font-black">{{ $item->User }} - {{ $item->action }}</div>
                        @if ($item->catatan)
                            <button class="btn btn-xs" onclick="catatan_{{ $loop->iteration }}.showModal()">catatan</button>
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
                    </div>
                    <hr />
                </li>
            @endforeach
        </ul>
    </div>
@endsection
