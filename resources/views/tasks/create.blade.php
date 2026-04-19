@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="min-h-screen bg-[#E7EFC7] p-6">
    <div class="max-w-lg mx-auto">

        <div class="backdrop-blur-xl bg-white/20 border border-white/30 rounded-3xl p-6 shadow-xl space-y-6 animate-slide-up">

            {{-- BACK --}}
            <a href="{{ route('tasks.index') }}"
                class="text-sm text-[#3B3B1A]/70 hover:underline">
                ← Back to Tasks
            </a>

            {{-- TITLE --}}
            <div>
                <h2 class="text-3xl font-extrabold text-[#3B3B1A] tracking-tight">
                    Create Task
                </h2>
                <p class="text-[#3B3B1A]/70 text-sm mt-1">
                    Add a new task and stay productive ✨
                </p>
            </div>

            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-5">
                @csrf

                {{-- TITLE --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A]">
                        Task Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="e.g. Finish UI design"
                        class="mt-1 block w-full rounded-xl
                               bg-white/40 border border-white/40
                               px-4 py-3
                               text-[#3B3B1A]
                               placeholder:text-[#3B3B1A]/40
                               focus:outline-none
                               focus:ring-2 focus:ring-[#8A784E]
                               focus:border-[#8A784E]"
                    >
                </div>

                {{-- DEADLINE --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A]">
                        Deadline
                    </label>
                    <input
                        type="date"
                        name="deadline"
                        class="mt-1 block w-full rounded-xl
                               bg-white/40 border border-white/40
                               px-4 py-3
                               text-[#3B3B1A]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#8A784E]
                               focus:border-[#8A784E]"
                    >
                </div>

                {{-- ENERGY --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A]">
                        Energy Level
                    </label>
                    <select
                        name="energy_level"
                        class="mt-1 block w-full rounded-xl
                               bg-white/40 border border-white/40
                               px-4 py-3
                               text-[#3B3B1A]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#8A784E]
                               focus:border-[#8A784E]">

                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="bg-[#8A784E] text-[#E7EFC7]
                               px-6 py-2 rounded-xl
                               font-semibold
                               hover:bg-[#7A6A45]
                               hover:scale-105
                               transition shadow-lg">
                        Create Task
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
