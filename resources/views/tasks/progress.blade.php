@extends('layouts.app')

@section('title', 'Add Progress - ' . $task->title)

@section('content')
<div class="min-h-screen bg-[#E7EFC7] p-6">
    <div class="max-w-3xl mx-auto">

        <div class="backdrop-blur-xl bg-white/15 border border-white/30 rounded-3xl shadow-2xl p-8 animate-slide-up space-y-6">

            {{-- BACK --}}
            <a href="{{ route('tasks.show', $task) }}"
               class="inline-flex items-center gap-2 text-sm
                      text-[#3B3B1A]/70 hover:underline">
                ← Back to Task
            </a>

            {{-- TITLE --}}
            <div>
                <h2 class="text-3xl font-extrabold text-[#3B3B1A]">
                    Add Progress
                </h2>
                <p class="text-[#3B3B1A]/70 mt-1">
                    for task: <span class="font-semibold">{{ $task->title }}</span>
                </p>
            </div>

            {{-- FORM --}}
            <form action="{{ route('tasks.addProgress', $task) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-5">
                @csrf

                {{-- DATE --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                        Date
                    </label>
                    <input type="date" name="date" required
                        class="w-full rounded-xl
                               bg-[#3B3B1A]/10
                               border border-white/40
                               px-4 py-3
                               text-[#3B3B1A]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#8A784E]/50">
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                        Description
                    </label>
                    <textarea name="desc" rows="4" required
                        placeholder="Describe what you have done..."
                        class="w-full rounded-xl
                               bg-[#3B3B1A]/10
                               border border-white/40
                               px-4 py-3
                               text-[#3B3B1A]
                               placeholder:text-[#3B3B1A]/50
                               focus:outline-none
                               focus:ring-2 focus:ring-[#8A784E]/50"></textarea>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                        Status
                    </label>
                    <select name="status" required
                        class="w-full rounded-xl
                               bg-[#3B3B1A]/10
                               text-[#3B3B1A]
                               border border-white/40
                               px-4 py-3
                               focus:outline-none
                               focus:ring-2 focus:ring-[#8A784E]/50
                               appearance-none">
                        <option value="not_started" class="bg-[#7A6A45] text-[#E7EFC7]">
                            Not started
                        </option>
                        <option value="in_progress" class="bg-[#7A6A45] text-[#E7EFC7]">
                            In progress
                        </option>
                        <option value="completed" class="bg-[#7A6A45] text-[#E7EFC7]">
                            Completed
                        </option>
                    </select>
                </div>

                {{-- DOCUMENTATION --}}
                <div>
                    <label class="block text-sm font-medium text-[#3B3B1A] mb-1">
                        Documentation (max 4 files)
                    </label>
                    <input type="file" name="docs[]" multiple
                        class="w-full rounded-xl
                               bg-white/40
                               border border-white/40
                               px-4 py-2
                               text-sm text-[#3B3B1A]">
                </div>

                {{-- SUBMIT --}}
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-[#8A784E]
                               text-[#E7EFC7]
                               px-6 py-3
                               rounded-xl
                               font-semibold
                               hover:bg-[#7A6A45]
                               hover:scale-[1.03]
                               transition-all duration-300
                               shadow-lg">
                        Save Progress
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ANIMATION --}}
<style>
@keyframes slide-up {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slide-up {
    animation: slide-up .6s ease-out;
}
</style>
@endsection
