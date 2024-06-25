@extends('tracking.layout')

@section('content')
    <div class="bg-primary p-4 flex-none">
        <h1 class="text-xl text-primary-content">Riwayat</h1>
    </div>
    <div class="flex flex-col md:flex-row px-4 gap-2 justify-between flex-none">
        <div class="">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-neutral">Sebelumnya</a>
        </div>
    </div>
    <div class="px-4 overflow-y-auto">

        <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical">
            @php
                $i = 1;
            @endphp
            @foreach ($data as $item)
                <li>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    @if ($i % 2 == 0)
                    <div class="timeline-start mb-10 md:text-end">
                        <time class="font-mono italic">{{ indonesiaDate($item->created_at) }} {{ $item->created_at->format('H:i:s') }}</time>
                        <div class="text-lg font-black">{{ $item->User }} - {{ $item->action }}</div>
                        {{ $item->catatan }}
                    </div>
                    @else
                    <div class="timeline-end mb-10">
                        <time class="font-mono italic">{{ indonesiaDate($item->created_at) }} {{ $item->created_at->format('H:i:s') }}</time>
                        <div class="text-lg font-black">{{ $item->User }} - {{ $item->action }}</div>
                        {{ $item->catatan }}
                    </div>
                    @endif
                    <hr />
                </li>
                @php
                    $i++;
                @endphp
            @endforeach
        </ul>

    </div>
@endsection
