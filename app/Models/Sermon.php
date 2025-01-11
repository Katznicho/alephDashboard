<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    //            $table->string('title');
    // $table->string('sermon_reading')->nullable();
    // $table->text('description');
    // $table->string('video_url')->nullable();
    // $table->string('audio_url')->nullable();
    // $table->string('image')->nullable();
    // $table->date('date');

    protected $table = 'sermons';
    protected $fillable = [
        'title',
        'sermon_reading',
        'description',
        'video_url',
        'audio_url',
        'image',
        'date',
    ];
}
