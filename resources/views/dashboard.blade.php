@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-[calc(100vh-197px)] bg-[#E7EFC7] pb-24 pt-7">
    <div class="px-6 sm:px-12">
        <h1 class="text-[32px] font-black leading-tight text-[#444422]">
            Welcome Back!
        </h1>
    </div>

    <div class="mt-7 grid gap-8 px-6 lg:grid-cols-[460px_minmax(0,805px)] lg:gap-[83px] lg:px-[59px]">
        <section class="h-auto rounded-[31px] border border-white bg-[#E7EFC7] px-8 py-6 shadow-[0_4px_30px_rgba(0,0,0,0.17)] lg:h-[422px]">
            <div class="flex items-center gap-6">
                <div class="flex h-[50px] w-[50px] items-center justify-center rounded-[10px] bg-[#8A784E]">
                    <span class="h-6 w-6 rounded-full border-[3px] border-[#E7EFC7]"></span>
                </div>
                <h2 class="text-xl font-extrabold text-black/60">
                    Focus Timer
                </h2>
            </div>

            <form class="mt-[18px] space-y-[26px]">
                <div>
                    <label class="mb-2 block text-[13px] font-semibold text-black/50">
                        Focus Duration (minutes)
                    </label>
                    <div class="grid grid-cols-[27px_1fr_27px] items-center gap-[18px]">
                        <button type="button" onclick="changeValue('focus-duration', -1)"
                            class="h-[34px] rounded-[10px] bg-white/60 text-2xl leading-none text-black/50 transition hover:bg-white">
                            -
                        </button>

                        <input type="number" id="focus-duration" value="25" min="1"
                            class="no-spinner h-14 w-full rounded-xl border-0 bg-black/10 px-4 text-center text-base font-semibold text-black/50 focus:ring-2 focus:ring-[#8A784E]/50">

                        <button type="button" onclick="changeValue('focus-duration', 1)"
                            class="h-[34px] rounded-[10px] bg-white/60 text-2xl leading-none text-black/60 transition hover:bg-white">
                            +
                        </button>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-[13px] font-semibold text-black/50">
                        Break Duration (minutes)
                    </label>
                    <div class="grid grid-cols-[27px_1fr_27px] items-center gap-[18px]">
                        <button type="button" onclick="changeValue('break-duration', -1)"
                            class="h-[34px] rounded-[10px] bg-white/60 text-2xl leading-none text-black/50 transition hover:bg-white">
                            -
                        </button>

                        <input type="number" id="break-duration" value="5" min="1"
                            class="no-spinner h-14 w-full rounded-xl border-0 bg-black/10 px-4 text-center text-base font-semibold text-black/50 focus:ring-2 focus:ring-[#8A784E]/50">

                        <button type="button" onclick="changeValue('break-duration', 1)"
                            class="h-[34px] rounded-[10px] bg-white/60 text-2xl leading-none text-black/60 transition hover:bg-white">
                            +
                        </button>
                    </div>
                </div>

                <button type="button" id="start-dashboard-timer"
                    class="h-[72px] w-full rounded-[15px] bg-[#8A784E] text-[15px] font-black text-[#E7EFC7]/90 shadow transition hover:bg-[#7A6A45] sm:max-w-[394px]">
                    Start Focus Session
                </button>
            </form>
        </section>

        <section class="h-auto rounded-[31px] border border-white bg-[#E7EFC7] px-8 py-6 shadow-[0_4px_30px_rgba(0,0,0,0.17)] lg:h-[422px]">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-xl font-bold text-black/60">
                    My Task
                </h2>

                <a href="{{ route('tasks.create') }}"
                    class="flex h-[52px] w-[126px] items-center justify-center rounded-[10px] bg-[#8A784E] text-base font-semibold text-white transition hover:bg-[#7A6A45]">
                    + Add Task
                </a>
            </div>

            <div class="mt-8 space-y-[15px] overflow-y-auto pr-1 lg:max-h-[280px]">
                @forelse($tasks as $task)
                    <a href="{{ route('tasks.show', $task) }}"
                       class="block rounded-xl bg-[#8A784E]/20 px-5 py-4 transition hover:bg-[#8A784E]/30 lg:min-h-[93px]">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-base font-bold text-black/60">
                                    {{ $task->title }}
                                </h3>

                                <p class="mt-2 text-[11px] font-medium
                                    @if($task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast())
                                        text-red-700
                                    @else
                                        text-black/60
                                    @endif
                                ">
                                    @if($task->deadline)
                                        Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                                    @else
                                        No deadline
                                    @endif
                                </p>
                            </div>

                            @if($task->energy_level)
                                <span class="rounded-full bg-[#8A784E]/20 px-3 py-1 text-xs font-semibold text-black/60">
                                    {{ ucfirst($task->energy_level) }}
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl bg-[#8A784E]/20 px-5 py-8 text-center text-sm font-semibold text-black/50">
                        No tasks yet. Create your first task!
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
function changeValue(id, step) {
    const input = document.getElementById(id);
    let value = parseInt(input.value) || 1;
    value = Math.max(1, value + step);
    input.value = value;
}

document.getElementById('start-dashboard-timer').addEventListener('click', function() {
    const focus = document.getElementById('focus-duration').value;
    const brk = document.getElementById('break-duration').value;

    window.location.href = "{{ route('dashboard.timer') }}?focus=" + focus + "&break=" + brk;
});
</script>
@endsection
