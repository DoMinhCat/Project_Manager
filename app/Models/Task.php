<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'done',
        'priority',
        'due_at',
        'status',
    ];

    // Relationship
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // optional: cast done to boolean and due_at to datetime
    protected $casts = [
        'due_at' => 'datetime',
    ];
}
