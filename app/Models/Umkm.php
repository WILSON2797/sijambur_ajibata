<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = ['name', 'owner', 'description', 'category', 'phone', 'address', 'image'];
}
