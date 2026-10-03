<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagline',
        'title',
        'subtitle',
        'link',
        'image',
        'status',
    ];
}
