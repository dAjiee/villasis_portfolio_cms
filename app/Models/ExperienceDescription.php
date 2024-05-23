<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceDescription extends Model
{
    use HasFactory;

    protected $casts = [
        'order' => 'integer',
    ];

    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
}
