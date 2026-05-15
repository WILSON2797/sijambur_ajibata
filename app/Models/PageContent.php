<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'subtitle', 'content', 'image', 'image_2', 'image_3', 'section'];
}
