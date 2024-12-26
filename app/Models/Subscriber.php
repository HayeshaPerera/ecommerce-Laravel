<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    // Add email to the fillable array
    protected $fillable = ['email'];

    // Other model methods and properties
}
