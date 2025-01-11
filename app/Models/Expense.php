<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    //
    protected  $fillable = [
        'item_name',
        'amount',
        'date',
        'category',
        'payment_method',
        'received_by',
        'received_from',
        'description'
    ];
}
