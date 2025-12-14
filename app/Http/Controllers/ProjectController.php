<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('tasks')->get(); 
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|min:3|max:30',
            'description' => 'nullable|max:255',
            'due_at'      => 'nullable|date|not_before_today',
            'priority' => 'required'],
        [
        'due_at.not_before_today' => 'The due date cannot be in the past.',
    ]);

        $validated['owner_id'] = $request->user()->id;
        // Create project
        Project::create($validated);

        return redirect()->back()->with('success', [$validated['name'] . ' has been successfully created.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('project.detail', [
            'project' => $project,
            'tasks' => $project->tasks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'        => 'required|min:3|max:30',
            'description' => 'nullable|max:255',
            'due_at'      => 'nullable|date|not_before_today',
            'priority'    => 'required',
            'status'      => 'required',
            'auto_status' => 'sometimes|boolean',
        ],
        [
        'due_at.not_before_today' => 'The due date cannot be in the past.',
    ]);

        $project->update($validated);
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
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', [$project->name . ' has been deleted.']);
    }
}
