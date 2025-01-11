<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //


    protected $fillable = [
        'reference',
        'amount',
        'status',
        'type',
        'category',
        'provider',
        'currency',
        'description',
        'email',
        'phone',
        'name',
    ];
}
