@extends('layouts.app')

@section('title', 'Tasks List')

@section('content')
<div class="min-h-screen bg-[#E7EFC7] p-6">
    <div class="max-w-6xl mx-auto">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-extrabold text-[#3B3B1A] tracking-tight">
                My Tasks
            </h2>

            <a href="{{ route('tasks.create') }}"
                class="bg-[#8A784E] text-[#E7EFC7] px-5 py-2.5 rounded-xl hover:bg-[#7A6A45] hover:scale-105 transition shadow-lg">
                + New Task
            </a>
        </div>

        @if($tasks->count())
            <div class="grid md:grid-cols-2 gap-6">

                @foreach($tasks as $task)
                    <div
                        class="backdrop-blur-xl bg-white/15 border border-white/30 rounded-3xl p-5 shadow-xl hover:bg-white/20 transition">

                        {{-- TOP --}}
                        <div class="flex justify-between items-start gap-4 mb-4">

                            {{-- TITLE + DEADLINE --}}
                            <div>
                                <h3 class="text-lg font-semibold text-[#3B3B1A]">
                                    <a href="{{ route('tasks.show', $task) }}" class="hover:underline">
                                        {{ $task->title }}
                                    </a>
                                </h3>

                                <p class="text-sm mt-1
                                    @if($task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast())
                                        text-red-700
                                    @else
                                        text-[#3B3B1A]/70
                                    @endif
                                ">
                                    @if($task->deadline)
                                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                    @else
                                        No deadline
                                    @endif
                                </p>
                            </div>

                            {{-- ENERGY --}}
                            <span class="text-xs font-semibold px-3 py-1 rounded-full h-fit
                                @if($task->energy_level === 'high')
                                    bg-[#8A784E]/30 text-[#3B3B1A]
                                @elseif($task->energy_level === 'medium')
                                    bg-[#8A784E]/20 text-[#3B3B1A]/80
                                @else
                                    bg-gray-400/20 text-gray-700
                                @endif
                            ">
                                Energy: {{ ucfirst($task->energy_level) }}
                            </span>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex gap-2">
                            <a href="{{ route('tasks.show', $task) }}"
                                class="text-sm px-3 py-1.5 rounded-lg bg-white/30 text-[#3B3B1A] hover:bg-white/40 transition">
                                View
                            </a>

                            <a href="{{ route('tasks.edit', $task) }}"
                                class="text-sm px-3 py-1.5 rounded-lg bg-[#8A784E]/30 text-[#3B3B1A] hover:bg-[#8A784E]/40 transition">
                                Edit
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Delete this task?')"
                                    class="text-sm px-3 py-1.5 rounded-lg bg-red-500/80 text-[#E7EFC7] hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <div class="backdrop-blur-xl bg-white/15 border border-white/30 rounded-3xl p-10 text-center">
                <p class="text-[#3B3B1A]/70 text-lg">
                    No tasks yet. Create your first task ✨
                </p>
            </div>
        @endif

    </div>
</div>
@endsection
