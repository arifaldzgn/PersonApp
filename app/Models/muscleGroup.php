<?php

namespace App\Models;

use App\Models\variation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class muscleGroup extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name'
    ];

    public function variation()
    {
        return $this->hasMany(variation::class);
    }
}
