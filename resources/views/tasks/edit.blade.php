@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="min-h-screen bg-[#E7EFC7] p-6">
    <div class="max-w-lg mx-auto">

        <div class="backdrop-blur-xl bg-white/20 border border-white/30 rounded-3xl p-6 shadow-xl space-y-6">

            {{-- BACK --}}
            <a href="{{ route('tasks.index') }}"
                class="text-sm text-[#3B3B1A]/70 hover:underline">
                ← Back to Tasks
            </a>

            {{-- TITLE --}}
            <h2 class="text-3xl font-extrabold text-[#3B3B1A] tracking-tight">
                Edit Task
            </h2>

            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- TITLE --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A]">
                        Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $task->title) }}"
                        required
                        class="mt-1 block w-full rounded-xl bg-white/40 border border-white/40 text-[#3B3B1A]
                               focus:outline-none focus:ring-2 focus:ring-[#8A784E] focus:border-[#8A784E]"
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
                        value="{{ old('deadline', $task->deadline) }}"
                        class="mt-1 block w-full rounded-xl bg-white/40 border border-white/40 text-[#3B3B1A]
                               focus:outline-none focus:ring-2 focus:ring-[#8A784E] focus:border-[#8A784E]"
                    >
                </div>

                {{-- ENERGY --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A]">
                        Energy Level
                    </label>
                    <select
                        name="energy_level"
                        class="mt-1 block w-full rounded-xl bg-white/40 border border-white/40 text-[#3B3B1A]
                               focus:outline-none focus:ring-2 focus:ring-[#8A784E] focus:border-[#8A784E]">

                        <option value="low" {{ $task->energy_level === 'low' ? 'selected' : '' }}>
                            Low
                        </option>
                        <option value="medium" {{ $task->energy_level === 'medium' ? 'selected' : '' }}>
                            Medium
                        </option>
                        <option value="high" {{ $task->energy_level === 'high' ? 'selected' : '' }}>
                            High
                        </option>
                    </select>
                </div>

                {{-- ACTION --}}
                <div class="pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="bg-[#8A784E] text-[#E7EFC7] px-6 py-2 rounded-xl
                               hover:bg-[#7A6A45] hover:scale-105 transition shadow-lg">
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
