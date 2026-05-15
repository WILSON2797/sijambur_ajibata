<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $fillable = ['name', 'description', 'location', 'category', 'image', 'is_featured'];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
