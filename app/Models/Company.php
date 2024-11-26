<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasUuids;

    protected $fillable = [
        'company_num',
        'ruc',
        'name',
        'status',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function information(): HasOne
    {
        return $this->hasOne(CompanyInformation::class);
    }


    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->company_num = substr($model->ruc, -1);
        });
        self::updating(function($model){
            $model->company_num = substr($model->ruc, -1);
        });
    }
}
