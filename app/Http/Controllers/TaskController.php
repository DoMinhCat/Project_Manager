<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        $project = Project::findOrFail($project_id);

    return view('task.new', [
        'project' => $project,
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $project_id)
    {
        $validated = $request->validate([
            'title'        => 'required|min:3|max:255',
            'description' => 'nullable|max:1023',
            'priority' => 'required|min:1|max:3',
            'deadline'      => 'nullable|date|not_before_today',
        ]);
        $validated['project_id'] = $project_id;
        // Create project
        Task::create($validated);

        return redirect()
        ->route('one_project', ['project_id' => $validated['project_id']])
        ->with('success', $validated['title'] . ' has been successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($project_id, $task_id)
    {
        $task = Task::where('id', $task_id)->firstOrFail();
        return view('task.task', [
            'task' => $task,
            'project' => $task->project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
