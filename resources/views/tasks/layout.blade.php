@extends('layouts.app')

@section('title', $title ?? 'Tasks')

@section('content')
<div class="grid md:grid-cols-3 gap-4">

    {{-- Kiri: Optional Sidebar / Timer --}}
    @if(isset($sidebar))
        <div class="bg-white p-4 rounded shadow">
            {!! $sidebar !!}
        </div>
    @endif

    {{-- Kanan: Main content --}}
    <div class="@if(isset($sidebar)) md:col-span-2 @else md:col-span-3 @endif bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold">{{ $mainTitle ?? '' }}</h2>
            @if(isset($actionButton))
                {!! $actionButton !!}
            @endif
        </div>
        {!! $mainContent !!}
    </div>

</div>
@endsection
