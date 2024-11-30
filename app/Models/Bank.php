<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'description',
    ];
    public function acounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
