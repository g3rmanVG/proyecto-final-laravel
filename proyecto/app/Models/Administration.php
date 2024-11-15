<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    protected $table = 'administration';

    protected $fillable = ['username', 'password'];

    public $timestamps = false;
}
