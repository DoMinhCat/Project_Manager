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
        ]);

        $validated['owner_id'] = $request->user()->id;
        // Create project
        Project::create($validated);

        return redirect()
            ->route('project.all')
            ->with('success', $validated['name'] . ' has been successfully created.');
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
        ]);

        $project->update($validated);
        return redirect()
            ->route('project.detail', $project)
            ->with('success', $validated['name'] . ' has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('project.all')->with('success', $project->name . ' has been deleted.' );
    }
}
