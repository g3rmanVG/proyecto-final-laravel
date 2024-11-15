<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    // Define la tabla asociada a este modelo.
    protected $table = 'administration';

    // Especificamos los campos que pueden ser asignados.
    protected $fillable = ['username', 'password'];

    public $timestamps = false;
}
