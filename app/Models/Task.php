<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date'
    ];

    /**
     * @var string
     */
    private $status;
    /**
     * @var mixed
     */
    private $due_date;

    //Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function dependencies()
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'task_id', 'dependent_task_id')
            ->withTimestamps();
    }

    public function dependentTasks()
    {
        return $this->belongsToMany(Task::class, 'task_dependencies', 'dependent_task_id', 'task_id')
            ->withTimestamps();
    }


    //Methods
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    public function markAsIncomplete()
    {
        $this->status = 'incomplete';
        $this->save();
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isOverdue()
    {
        return $this->due_date < now() && !$this->isCompleted();
    }
}
