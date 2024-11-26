<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyInformation extends Model
{
    use HasUuids;

    protected $fillable = [
        'phone',
        'email',
        'entity_keys',
        'address',
        'company_id',
        'department_id',
        'province_id',
        'district_id',
    ];

    protected $casts = [
        'entity_keys' => 'array',
    ];

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
