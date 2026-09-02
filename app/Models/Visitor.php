<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'purpose',
        'invited_by',
        'date',
        'time',
        'service',
    ];
}