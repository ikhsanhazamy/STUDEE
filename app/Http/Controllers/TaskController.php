<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // 🟢 Show all tasks
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('tasks.index', compact('tasks'));
    }

    // 🟢 Show create form
    public function create()
    {
        return view('tasks.create');
    }

    // 🟢 Store new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'deadline' => 'nullable|date',
            'energy_level' => 'required'
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'deadline' => $request->deadline,
            'energy_level' => $request->energy_level,
        ]);

        return redirect('/tasks')->with('success', 'Task created!');
    }

    // 🟢 Show detail
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // 🟡 Edit
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // 🟡 Update
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'deadline' => 'nullable',
            'energy_level' => 'required'
        ]);

        $task->update($request->all());
        return redirect('/tasks')->with('success', 'Task updated!');
    }

    // 🔴 Delete
    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted!');
    }
}
