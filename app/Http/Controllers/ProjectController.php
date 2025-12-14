<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['tasks', 'members'])
        ->where('owner_id', Auth::id())
        ->orWhereHas('members', function ($query) {
            $query->where('users.id', Auth::id());
        })->get();
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
        $project = Project::create($validated);

        $project->members()->attach($request->user()->id,['permission' => 'owner']);
        return redirect()->back()->with('success', [$validated['name'] . ' has been successfully created.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if($project->userPermission(Auth::user()) == null){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }
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
        if($project->userPermission(Auth::user()) != 'edit' || $project->userPermission(Auth::user()) != 'owner'){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }

        $validated = $request->validate([
            'name'        => 'required|min:3|max:30',
            'description' => 'nullable|max:255',
            'due_at'      => 'nullable|date|not_before_today',
            'priority'    => 'required',
            'status'      => 'sometimes',
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
        if($project->userPermission(Auth::user()) != 'owner'){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }
        $project->delete();
        return redirect()->back()->with('success', [$project->name . ' has been deleted.']);
    }

    public function share(Request $request, Project $project)
    {
        if($project->userPermission(Auth::user()) != 'edit' || $project->userPermission(Auth::user()) != 'owner'){
            abort(403, 'You don\'t have the right permission to perform this action.');
        }
        $validated = $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'permission' => 'required|in:view,collaborate,edit'
        ]);
        
        foreach ($validated['users'] as $userId) {
            $project->members()->syncWithoutDetaching([$userId => ['permission' => $validated['permission']]]);
        }
        
        return back()->with('success', ['Project shared successfully']);
    }
}
