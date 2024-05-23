<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    // public function getIconUrlAttribute($value)
    // {
    //     return Storage::disk('s3')->url($value);
    // }
}
