<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index(Request $request)
    {
        
        $sort = $request->query('sort');

        $tasksByStatus = Task::all()->groupBy(function($task) {
            if ($task->status) return 'Completed';
            if ($task->due_at && $task->due_at < now()) return 'Overdue';
            return 'In progress';
        })->map->count();

        $overdueTasks = Task::where('done', false)
                            ->where('due_at', '<', now())
                            ->count();

        $recentTasks = Task::where('created_at', '>=', now()->subDays(7))->count();
        
        $projects = Project::with('tasks');

        if ($sort === 'priority') {
            $projects->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END
            ");
        } 
        elseif ($sort === 'due_at') {
            $projects->orderBy('due_at', 'desc');
        } 
        elseif ($sort === 'none') { 
            $projects->orderBy('id');
        }
        elseif ($sort === 'name'){
            $projects->orderBy('name');
        }
            elseif ($sort === 'number_of_tasks'){
                $projects->withCount('tasks')
                         ->orderBy('tasks_count', 'desc');
            }
        else
        {
            $sort === 'none';
        }

        $projects = $projects->get();

        return view('dashboard', compact('tasksByStatus', 'overdueTasks', 'recentTasks', 'projects','sort'));
    }
}
