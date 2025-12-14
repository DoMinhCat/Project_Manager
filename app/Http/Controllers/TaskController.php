<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        if($project->userPermission(Auth::user()) == null){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }
        
        $validated = $request->validate([
            'name'        => 'required|min:3|max:255',
            'description' => 'nullable|max:1023',
            'priority' => 'required',
            'due_at'      => 'nullable|date|not_before_today',
        ],
        [
        'due_at.not_before_today' => 'The due date cannot be in the past.',
        ]);
        $validated['project_id'] = $project->id;

        Task::create($validated);
        $messages = [];
        $messages[] = $validated['name'] . ' has been successfully created.';

        if($project->autoUpdateStatus()){
            $current_status = ucfirst(str_replace('_', ' ', $project->status));
            $messages[] = 'Project status was automatically updated to ' . $current_status . '.';
        }
        return redirect()->back()->with('success', $messages);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        if($project->userPermission(Auth::user()) == null){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }
        $validated = $request->validate([
            'name'        => 'required|min:3|max:255',
            'description' => 'nullable|max:1023',
            'priority' => 'required',
            'due_at'      => 'nullable|date|not_before_today',
        ],
        [
        'due_at.not_before_today' => 'The due date cannot be in the past.',
    ]);
        $task->update($validated);
        $messages = [];
        $messages[] = $validated['name'] . ' has been successfully updated.';
        if($project->autoUpdateStatus()){
            $current_status = ucfirst(str_replace('_', ' ', $project->status));
            $messages[] = 'Project status was automatically updated to ' . $current_status . '.';
        }
        return redirect()->back()->with('success', $messages);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        if($project->userPermission(Auth::user()) == null){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }
        $task->delete();
        $messages = [];
        $messages[] = $task->name . ' has been deleted.';
        if($project->autoUpdateStatus()){
            $current_status = ucfirst(str_replace('_', ' ', $project->status));
            $messages[] = 'Project status was automatically updated to ' . $current_status . '.';
        }
        return redirect()->back()->with('success', $messages);
    }

    public function updateStatus(Request $request, Project $project, Task $task)
    {
        if($project->userPermission(Auth::user()) == null){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }

        $validated = $request->validate([
            'status'        => 'required',
        ]);

        $task->update($validated);
        $messages = [];
        if($project->autoUpdateStatus()){
            $current_status = ucfirst(str_replace('_', ' ', $project->status));
            $messages[] = 'Project status was automatically updated to ' . $current_status . '.';
        }
        return redirect()->back()->with('success', $messages);
    }
}
