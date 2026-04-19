@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="min-h-screen bg-[#E7EFC7] p-6">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- BACK --}}
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 text-sm text-[#3B3B1A]/70 hover:underline">
            ← Back to Dashboard
        </a>

        {{-- HEADER --}}
        <div class="backdrop-blur-xl bg-white/20 border border-white/30 rounded-3xl p-6 shadow-xl">

            <div class="flex justify-between items-start gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-[#3B3B1A]">
                        {{ $task->title }}
                    </h2>
                    <p class="text-sm text-[#3B3B1A]/70 mt-1">
                        Deadline:
                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-' }}
                    </p>
                </div>

                <div class="flex flex-col gap-2 text-right">
                    {{-- STATUS --}}
                    <span class="text-xs font-semibold px-3 py-1 rounded-full
                        @if($task->last_status=='completed')
                            bg-green-600/20 text-green-800
                        @elseif($task->last_status=='in_progress')
                            bg-[#8A784E]/30 text-[#3B3B1A]
                        @else
                            bg-gray-500/20 text-gray-700
                        @endif">
                        {{ ucfirst(str_replace('_',' ', $task->last_status ?? 'not started')) }}
                    </span>

                    {{-- ENERGY --}}
                    <span class="text-xs font-medium px-3 py-1 rounded-full
                        @if($task->energy_level=='high')
                            bg-[#8A784E]/30 text-[#3B3B1A]
                        @elseif($task->energy_level=='medium')
                            bg-[#8A784E]/20 text-[#3B3B1A]/80
                        @else
                            bg-gray-400/20 text-gray-700
                        @endif">
                        Energy: {{ ucfirst($task->energy_level ?? 'medium') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- FOCUS TIMER --}}
        <div class="backdrop-blur-xl bg-white/15 border border-white/30 rounded-3xl p-6 shadow-xl">
            <h3 class="text-lg font-bold text-[#3B3B1A] mb-4">
                ⏱ Focus Timer
            </h3>

            <div class="text-4xl font-extrabold text-[#3B3B1A] mb-4" id="timer-display">
                25:00
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="#" id="start-timer-btn"
                   class="bg-[#8A784E] text-[#E7EFC7] px-4 py-2 rounded-xl font-semibold hover:bg-[#7A6A45] transition shadow">
                    Start Focus
                </a>
                <button class="bg-white/40 text-[#3B3B1A] px-4 py-2 rounded-xl hover:bg-white/60 transition">
                    Pause
                </button>
                <button class="bg-red-500/80 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition">
                    Reset
                </button>
            </div>
        </div>

        {{-- FILES / LINKS / NOTES --}}
        <form action="{{ route('tasks.saveAll', $task) }}"
              method="POST"
              enctype="multipart/form-data"
              class="backdrop-blur-xl bg-white/15 border border-white/30 rounded-3xl p-6 shadow-xl space-y-6">
            @csrf

            {{-- FILES --}}
            <div>
                <h3 class="font-semibold text-[#3B3B1A] mb-2">📁 Files</h3>
                <ul class="list-disc list-inside text-sm text-[#3B3B1A]/80 space-y-1">
                    @foreach($task->files ?? [] as $file)
                        <li>
                            <a href="{{ asset('storage/'.$file) }}" target="_blank"
                               class="hover:underline text-[#3B3B1A]">
                                {{ basename($file) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <input type="file" name="files[]" multiple
                    class="mt-2 w-full rounded-xl bg-white/40 border border-white/40 px-3 py-2 text-sm">
            </div>

            {{-- LINKS --}}
            <div>
                <h3 class="font-semibold text-[#3B3B1A] mb-2">🔗 Links</h3>
                <ul class="list-disc list-inside text-sm text-[#3B3B1A]/80 space-y-1">
                    @foreach($task->links ?? [] as $link)
                        <li>
                            <a href="{{ $link }}" target="_blank"
                               class="hover:underline text-[#3B3B1A]">
                                {{ $link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <input type="url" name="links[]"
                    placeholder="https://..."
                    class="mt-2 w-full rounded-xl bg-white/40 border border-white/40 px-3 py-2 text-sm">
            </div>

            {{-- NOTES --}}
            <div>
                <h3 class="font-semibold text-[#3B3B1A] mb-2">📝 Notes</h3>
                <ul class="list-disc list-inside text-sm text-[#3B3B1A]/80 space-y-1">
                    @foreach($task->notes ?? [] as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
                <textarea name="notes[]" rows="3"
                    placeholder="Add note..."
                    class="mt-2 w-full rounded-xl bg-white/40 border border-white/40 px-3 py-2 text-sm"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#8A784E] text-[#E7EFC7] px-6 py-2 rounded-xl font-semibold hover:bg-[#7A6A45] transition shadow">
                    Save All
                </button>
            </div>
        </form>

        {{-- PROGRESS LOG --}}
        <div class="backdrop-blur-xl bg-white/15 border border-white/30 rounded-3xl p-6 shadow-xl">
            <h3 class="font-bold text-[#3B3B1A] mb-3">✅ Progress Log</h3>

            @if($task->progress ?? false)
                <ul class="space-y-3 text-sm text-[#3B3B1A]/80">
                    @foreach($task->progress as $p)
                        <li class="bg-white/30 rounded-xl p-3">
                            <strong>{{ $p['date'] }}</strong> — {{ $p['desc'] }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-[#3B3B1A]/60">No progress yet.</p>
            @endif

            <a href="{{ route('tasks.progress', $task) }}"
               class="inline-block mt-4 bg-[#8A784E] text-[#E7EFC7] px-4 py-2 rounded-xl hover:bg-[#7A6A45] transition shadow">
                Add Progress
            </a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('start-timer-btn').addEventListener('click', function(e){
    e.preventDefault();
    window.location.href = `/tasks/{{ $task->id }}/timer?focus=25&break=5`;
});
</script>
@endsection
