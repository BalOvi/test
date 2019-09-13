<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'movie_id',
        'original_title',
        'genre',
        'release_date'
    ];
}
