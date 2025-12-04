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
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'        => 'required|min:3|max:255',
            'description' => 'nullable|max:1023',
            'priority' => 'required',
            'deadline'      => 'nullable|date|not_before_today',
        ]);
        $validated['project_id'] = $project->id;
        // Create project
        Task::create($validated);

        return redirect()
        ->route('project.detail', $project)
        ->with('success', $validated['title'] . ' has been successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        return view('task.detail', [
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
    public function destroy(Project $project, Task $task)
    {
        $task->delete();
        return redirect()->route('project.detail', $project)->with('success', $task->name . ' has been deleted.' );
    
    }
}
