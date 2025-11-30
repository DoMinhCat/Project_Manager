<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        
        $tasksByStatus = Task::all()->groupBy(function($task) {
            if ($task->done) return 'completed';
            if ($task->due_at && $task->due_at < now()) return 'overdue';
            return 'in_progress';
        })->map->count();

        $overdueTasks = Task::where('done', false)
                            ->where('due_at', '<', now())
                            ->count();

        $recentTasks = Task::where('created_at', '>=', now()->subDays(7))->count();
        
        $projects = Project::with('tasks')->get();

        return view('dashboard', compact('tasksByStatus', 'overdueTasks', 'recentTasks', 'projects'));
    }
}
