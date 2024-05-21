<?php

namespace App\Models;

use App\Models\workoutSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class workout extends Model
{
    use HasFactory;

    public function workoutSession()
    {
        return $this->hasMany(workoutSession::class);
    }
}
