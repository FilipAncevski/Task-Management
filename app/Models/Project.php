<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'description',
      'due_date'
    ];

    /**
     * @var mixed
     */
    private $due_date;

    //Relationships
    public  function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    //Methods
    public function isOverdue()
    {
        return $this->due_date < now();
    }

    public function completedTasksCount()
    {
        return $this->tasks()->where('status', 'completed')->count();
    }

    public function totalTaskCount()
    {
        return $this->tasks()->count();
    }
}
