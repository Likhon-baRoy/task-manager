<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show all tasks
    public function index()
    {
        $tasks = Task::when(request('status'), function ($q) {
            $q->where('status', request('status'));
        })
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('tasks.index', compact('tasks'));
    }

    // Show create form
    public function create()
    {
        return view('tasks.create');
    }

    // Store task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')
                        ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    // Show edit form
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return redirect('/tasks')->with('success', 'Task updated!');
    }

    // Delete task
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted!');
    }
}
