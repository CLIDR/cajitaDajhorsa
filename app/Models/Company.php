<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'company_num',
        'company_ruc',
        'company_name',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
