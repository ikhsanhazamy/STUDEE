// ==== Pomodoro Timer ====
let focusTime = 25 * 60;  // 25 menit fokus
let restTime = 5 * 60;    // 5 menit istirahat
let isFocus = true;       // status: focus/rest
let timer = focusTime;    
let interval = null;

const timerDisplay = document.getElementById('timerDisplay');
const startBtn = document.getElementById('startBtn');
const pauseBtn = document.getElementById('pauseBtn');
const resetBtn = document.getElementById('resetBtn');

// format detik jadi MM:SS
function formatTime(seconds){
    const m = Math.floor(seconds/60).toString().padStart(2,'0');
    const s = (seconds % 60).toString().padStart(2,'0');
    return `${m}:${s}`;
}

// update tampilan
function updateDisplay(){
    timerDisplay.textContent = formatTime(timer);
}

// tick setiap detik
function tick(){
    if(timer > 0){
        timer--;
        updateDisplay();
    } else {
        // switch mode
        isFocus = !isFocus;
        timer = isFocus ? focusTime : restTime;
        alert(isFocus ? "Focus time! Let's go!" : "Rest time! Take a break!");
        updateDisplay();
    }
}

// tombol start
startBtn.addEventListener('click', ()=>{
    if(!interval){
        interval = setInterval(tick,1000);
    }
});

// tombol pause
pauseBtn.addEventListener('click', ()=>{
    if(interval){
        clearInterval(interval);
        interval = null;
    }
});

// tombol reset
resetBtn.addEventListener('click', ()=>{
    clearInterval(interval);
    interval = null;
    timer = isFocus ? focusTime : restTime;
    updateDisplay();
});

// tampilkan awal
updateDisplay();
