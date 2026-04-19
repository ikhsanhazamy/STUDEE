<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Focus Timer - {{ $task ? $task->title : 'Focus Timer' }}</title>
    @vite('resources/css/app.css')
    <style>
        /* Progress bar */
        #progress-container {
            width: 300px;
            max-width: 90vw;
            height: 12px;
            background: rgba(255,255,255,0.2);
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 40px;
        }
        #progress {
            height: 100%;
            background: #8A784E;
            width: 0%;
            transition: width 0.3s linear;
        }

        /* Pulse animation for running timer */
        .running { animation: pulse 1s infinite; }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }

        /* Button hover */
        button:hover { cursor: pointer; }
    </style>
</head>

<body
    id="page"
    class="min-h-screen flex flex-col items-center justify-center
           bg-gradient-to-br from-[#1f2933] to-[#111827]
           text-[#E7EFC7] transition-colors duration-500 p-4"
>

    {{-- Back --}}
    <div class="absolute top-6 right-6">
        @if($task)
            <a href="{{ route('tasks.show', $task) }}"
               class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-sm">
                ← Back to Task
            </a>
        @else
            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-sm">
                ← Dashboard
            </a>
        @endif
    </div>

    {{-- Title --}}
    <h2 class="text-3xl sm:text-4xl font-bold mb-2 text-center">
        {{ $task ? $task->title : "It's Time to" }}
    </h2>

    {{-- Status --}}
    <div id="status"
         class="uppercase tracking-widest text-sm mb-6 text-[#E7EFC7]/70">
        Focus
    </div>

    {{-- Timer --}}
    <div id="timer"
         class="text-[5rem] sm:text-[7rem] font-black mb-6 leading-none">
        25:00
    </div>

    {{-- Progress Bar --}}
    <div id="progress-container">
        <div id="progress"></div>
    </div>

    {{-- Controls --}}
    <div class="flex items-center gap-4">
        <button id="start-btn"
            class="px-8 py-4 rounded-xl font-semibold
                   bg-[#8A784E] text-[#E7EFC7] hover:bg-[#7A6A45] transition shadow-lg">
            Start
        </button>

        <button id="reset-btn"
            class="px-6 py-4 rounded-xl font-semibold
                   bg-white/10 hover:bg-white/20 border border-white/20 transition">
            Reset
        </button>
    </div>

<script>
const focusDuration = {{ $focusDuration ?? 25 }} * 60;
const breakDuration = {{ $breakDuration ?? 5 }} * 60;

const state = {
    isFocus: true,
    timer: focusDuration,
    interval: null
};

const timerEl  = document.getElementById('timer');
const statusEl = document.getElementById('status');
const startBtn = document.getElementById('start-btn');
const resetBtn = document.getElementById('reset-btn');
const progress  = document.getElementById('progress');
const page     = document.getElementById('page');

function formatTime(seconds) {
    const m = Math.floor(seconds / 60).toString().padStart(2,'0');
    const s = (seconds % 60).toString().padStart(2,'0');
    return `${m}:${s}`;
}

function applyTheme() {
    if(state.isFocus){
        statusEl.textContent = 'Focus';
        page.classList.remove('bg-gradient-to-br','from-[#2f6f5f]','to-[#1e3f3a]');
        page.classList.add('bg-gradient-to-br','from-[#1f2933]','to-[#111827]');
        progress.style.background = '#8A784E';
    } else {
        statusEl.textContent = 'Break';
        page.classList.remove('bg-gradient-to-br','from-[#1f2933]','to-[#111827]');
        page.classList.add('bg-gradient-to-br','from-[#2f6f5f]','to-[#1e3f3a]');
        progress.style.background = '#2f6f5f';
    }
}

function updateProgress() {
    const total = state.isFocus ? focusDuration : breakDuration;
    const percent = ((total - state.timer) / total) * 100;
    progress.style.width = percent + '%';
}

function tick() {
    timerEl.textContent = formatTime(state.timer);
    updateProgress();
    if(state.timer <= 0){
        clearInterval(state.interval);
        state.interval = null;
        state.isFocus = !state.isFocus;
        state.timer = state.isFocus ? focusDuration : breakDuration;
        applyTheme();
        startBtn.textContent = 'Start';
        alert(state.isFocus ? 'Time to Focus!' : 'Break time!');
    }
}

function toggleTimer() {
    if(state.interval){
        clearInterval(state.interval);
        state.interval = null;
        startBtn.textContent = 'Resume';
        startBtn.classList.remove('running');
    } else {
        state.interval = setInterval(() => {
            state.timer--;
            tick();
        }, 1000);
        startBtn.textContent = 'Running...';
        startBtn.classList.add('running');
    }
}

// Event listeners
startBtn.addEventListener('click', toggleTimer);
resetBtn.addEventListener('click', () => {
    clearInterval(state.interval);
    state.interval = null;
    state.isFocus = true;
    state.timer = focusDuration;
    applyTheme();
    timerEl.textContent = formatTime(state.timer);
    progress.style.width = '0%';
    startBtn.textContent = 'Start';
    startBtn.classList.remove('running');
});

// Init
timerEl.textContent = formatTime(state.timer);
applyTheme();
progress.style.width = '0%';
</script>

</body>
</html>
