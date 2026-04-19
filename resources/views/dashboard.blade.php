@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-[#E7EFC7] p-6">
    <div class="max-w-7xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-10 animate-fade-in">
            <h1 class="text-4xl font-extrabold text-[#3B3B1A] mb-2 tracking-tight drop-shadow">
                Welcome Back!
            </h1>
            <p class="text-[#3B3B1A]/80 text-lg">
                Let's make today productive
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">

            {{-- TIMER --}}
            <div class="backdrop-blur-xl bg-white/20 border border-white/30 p-6 rounded-3xl shadow-2xl animate-slide-up">

                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#8A784E] flex items-center justify-center shadow-lg">
                        <span class="text-[#E7EFC7] font-bold text-xl">⏱️</span>
                    </div>
                    <h2 class="text-xl font-bold text-[#3B3B1A]">
                        Focus Timer
                    </h2>
                </div>

                <form class="space-y-6">

                    {{-- FOCUS --}}
                    <div>
                        <label class="block text-[#3B3B1A]/90 font-medium mb-2 text-sm">
                            Focus Duration (minutes)
                        </label>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="changeValue('focus-duration', -1)"
                                class="w-10 h-10 rounded-xl bg-white/30 text-[#3B3B1A] text-xl hover:bg-[#8A784E]/30 transition">−</button>

                            <input type="number" id="focus-duration" value="25" min="1"
                                class="w-full text-center bg-[#3B3B1A]/10 border border-white/30 rounded-xl px-4 py-3 text-[#3B3B1A] focus:outline-none focus:ring-2 focus:ring-[#8A784E]/50">

                            <button type="button" onclick="changeValue('focus-duration', 1)"
                                class="w-10 h-10 rounded-xl bg-white/30 text-[#3B3B1A] text-xl hover:bg-[#8A784E]/30 transition">+</button>
                        </div>
                    </div>

                    {{-- BREAK --}}
                    <div>
                        <label class="block text-[#3B3B1A]/90 font-medium mb-2 text-sm">
                            Break Duration (minutes)
                        </label>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="changeValue('break-duration', -1)"
                                class="w-10 h-10 rounded-xl bg-white/30 text-[#3B3B1A] text-xl hover:bg-[#8A784E]/30 transition">−</button>

                            <input type="number" id="break-duration" value="5" min="1"
                                class="w-full text-center bg-[#3B3B1A]/10 border border-white/30 rounded-xl px-4 py-3 text-[#3B3B1A] focus:outline-none focus:ring-2 focus:ring-[#8A784E]/50">

                            <button type="button" onclick="changeValue('break-duration', 1)"
                                class="w-10 h-10 rounded-xl bg-white/30 text-[#3B3B1A] text-xl hover:bg-[#8A784E]/30 transition">+</button>
                        </div>
                    </div>

                    <button type="button" id="start-dashboard-timer"
                        class="w-full bg-[#8A784E] text-[#E7EFC7] font-semibold py-4 rounded-xl hover:bg-[#7A6A45] hover:scale-[1.03] transition-all shadow-lg">
                        Start Focus Session
                    </button>
                </form>
            </div>

            {{-- TASK LIST --}}
            <div class="md:col-span-2 backdrop-blur-xl bg-white/15 border border-white/30 p-6 rounded-3xl shadow-2xl animate-slide-up">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-[#3B3B1A]">
                        My Tasks
                    </h2>

                    <a href="{{ route('tasks.create') }}"
                        class="bg-[#8A784E] text-[#E7EFC7] px-5 py-2.5 rounded-xl hover:bg-[#7A6A45] hover:scale-105 transition shadow-lg">
                        + Add Task
                    </a>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                    @forelse($tasks as $task)
                        <a href="{{ route('tasks.show', $task) }}"
                           class="block bg-[#8A784E]/10 border border-white/30 rounded-2xl p-4 hover:bg-[#8A784E]/20 transition">

                            <div class="flex justify-between items-start gap-4">

                                {{-- LEFT --}}
                                <div>
                                    <h3 class="text-[#3B3B1A] font-semibold text-lg">
                                        {{ $task->title }}
                                    </h3>

                                    {{-- DEADLINE --}}
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
                        </a>
                    @empty
                        <p class="text-[#3B3B1A]/70 text-center py-12">
                            No tasks yet. Create your first task!
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ANIMATION --}}
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slide-up {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in .6s ease-out; }
.animate-slide-up { animation: slide-up .6s ease-out; }
</style>
@endsection

@section('scripts')
<script>
function changeValue(id, step) {
    const input = document.getElementById(id);
    let value = parseInt(input.value) || 1;
    value = Math.max(1, value + step);
    input.value = value;
}

// START FOCUS SESSION
document.getElementById('start-dashboard-timer').addEventListener('click', function() {
    const focus = document.getElementById('focus-duration').value;
    const brk   = document.getElementById('break-duration').value;

    // arahkan ke halaman timer dengan query param
    window.location.href = "{{ route('dashboard.timer') }}?focus=" + focus + "&break=" + brk;
});
</script>
@endsection
