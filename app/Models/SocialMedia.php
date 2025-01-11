<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    //


    protected $fillable = [
        'instagram',
        'x',
        'facebook',
        'linkedin',
        'tiktok',
        'youtube',
        'telegram',
        'snapchat',
    ];
}
