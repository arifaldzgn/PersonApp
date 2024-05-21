<?php

namespace App\Models;

use App\Models\muscleGroup;
use App\Models\workoutSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class variation extends Model
{
    use HasFactory;

    protected $fillable = [
        'muscle_group_id', 'name', 'description', 'equipment', 'difficulty'
    ];

    public function muscleGroup()
    {
        return $this->belongsTo(muscleGroup::class);
    }

    public function workoutSessions()
    {
        return $this->hasMany(workoutSession::class);
    }
}
