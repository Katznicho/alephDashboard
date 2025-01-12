<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    //

    protected $fillable = [
        'name',
        'position',
        'facebook',
        'twitter',
        'instagram',
        'bio',
        'image',
    ];
}
