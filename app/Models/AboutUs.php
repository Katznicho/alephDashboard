<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    //
    // $table->string('title');
    // $table->text('description');
    // $table->string('image')->nullable();
    // $table->text("our_mission")->nullable();
    // $table->text("our_vision")->nullable();

    protected $fillable = ['title', 'description', 'image', 'our_mission', 'our_vision'];
}
