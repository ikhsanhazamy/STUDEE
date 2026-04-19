<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Default route
|--------------------------------------------------------------------------
| Jika belum login -> login
| Jika sudah login -> dashboard
*/
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Guest only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', function (Request $r) {
        $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|confirmed'
        ]);

        $user = User::create([
            'name' => $r->name,
            'email' => $r->email,
            'password' => bcrypt($r->password)
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    });

    // Login
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', function (Request $r) {
        $credentials = $r->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $r->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $r) {
    Auth::logout();
    $r->session()->invalidate();
    $r->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $tasks = Auth::user()->tasks()->latest()->take(5)->get();
        return view('dashboard', compact('tasks'));
    })->name('dashboard');

    // Dashboard full screen timer
    Route::get('/dashboard/timer', function (Request $r) {
        return view('tasks.timer', [
            'task' => null,
            'focusDuration' => $r->query('focus', 25),
            'breakDuration' => $r->query('break', 5)
        ]);
    })->name('dashboard.timer');

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    */

    // Index
    Route::get('/tasks', function () {
        $tasks = Auth::user()->tasks;
        return view('tasks.index', compact('tasks'));
    })->name('tasks.index');

    // Create
    Route::get('/tasks/create', fn() => view('tasks.create'))->name('tasks.create');

    // Store
    Route::post('/tasks', function (Request $r) {
        $r->validate([
            'title' => 'required',
            'deadline' => 'nullable|date',
            'energy_level' => 'nullable|in:low,medium,high'
        ]);

        Auth::user()->tasks()->create(
            $r->only('title', 'deadline', 'energy_level')
        );

        return redirect()->route('tasks.index');
    })->name('tasks.store');

    // Show
    Route::get('/tasks/{task}', function (Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);
        return view('tasks.show', compact('task'));
    })->name('tasks.show');

    // Save all (files, links, notes)
    Route::post('/tasks/{task}/save-all', function (Request $r, Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);

        // Files
        $files = $task->files ?? [];
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $f) {
                $files[] = $f->store('tasks_files', 'public');
            }
        }

        // Links
        $links = array_filter(array_merge(
            $task->links ?? [],
            $r->links ?? []
        ));

        // Notes
        $notes = array_filter(array_merge(
            $task->notes ?? [],
            $r->notes ?? []
        ));

        $task->update([
            'files' => $files,
            'links' => $links,
            'notes' => $notes
        ]);

        return back()->with('success', 'Task updated!');
    })->name('tasks.saveAll');

    // Progress page
    Route::get('/tasks/{task}/progress', function (Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);
        return view('tasks.progress', compact('task'));
    })->name('tasks.progress');

    // Add progress
    Route::post('/tasks/{task}/add-progress', function (Request $r, Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);

        $r->validate([
            'date' => 'required|date',
            'desc' => 'required|string',
            'status' => 'required|in:not_started,in_progress,completed'
        ]);

        $docs = [];
        if ($r->hasFile('docs')) {
            foreach ($r->file('docs') as $f) {
                $docs[] = $f->store('progress_docs', 'public');
            }
        }

        $task->progress = array_merge($task->progress ?? [], [[
            'date' => $r->date,
            'desc' => $r->desc,
            'status' => $r->status,
            'docs' => $docs
        ]]);

        $task->save();
        return back();
    })->name('tasks.addProgress');

    // Edit
    Route::get('/tasks/{task}/edit', function (Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);
        return view('tasks.edit', compact('task'));
    })->name('tasks.edit');

    // Update
    Route::put('/tasks/{task}', function (Request $r, Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);

        $r->validate([
            'title' => 'required',
            'deadline' => 'nullable|date',
            'energy_level' => 'nullable|in:low,medium,high'
        ]);

        $task->update(
            $r->only('title', 'deadline', 'energy_level')
        );

        return redirect()->route('tasks.index');
    })->name('tasks.update');

    // Delete
    Route::delete('/tasks/{task}', function (Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);
        $task->delete();
        return redirect()->route('tasks.index');
    })->name('tasks.destroy');

    // Task full-screen timer
    Route::get('/tasks/{task}/timer', function (Task $task) {
        abort_if($task->user_id !== Auth::id(), 403);
        return view('tasks.timer', compact('task'));
    })->name('tasks.timer');
});