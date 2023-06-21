<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'options'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public $timestamps = false;

}
