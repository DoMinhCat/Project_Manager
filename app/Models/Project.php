<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'due_at',
        'status',
        'priority',
        'owner_id',
        'auto_status',
    ];

    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function autoUpdateStatus(): bool
    {
        if (! $this->auto_status) {
            return false;
        }
        $status_before = $this->status;
        $total = $this->tasks()->count();
        $completed = $this->tasks()->where('status', 1)->count();

        if ($total === 0) {
            $this->status = 'on_hold';
        } elseif ($completed === $total) {
            $this->status = 'completed';
        } else {
            $this->status = 'in_progress';
        }

        if ($status_before !== $this->status) {
            $this->save();
            return true;
        }

        return false;
    }

    // Relationship: One project -> many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
