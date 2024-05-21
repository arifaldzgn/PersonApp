<?php

namespace App\Models;

use App\Models\workout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class workoutSession extends Model
{
    use HasFactory;

    public function workout()
    {
        return $this->belongsTo(workout::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
