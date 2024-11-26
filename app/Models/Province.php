<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $casts = [
        'id' => 'string', // Cast 'id' to string
    ];
}
