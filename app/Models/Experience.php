<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Experience extends Model
{
    use HasFactory;

    public function descriptions()
    {
        return $this->hasMany(ExperienceDescription::class);
        
    }

//     public function getIconUrlAttribute($value)
//     {
//         return Storage::disk('s3')->url($value);
//     }
}
