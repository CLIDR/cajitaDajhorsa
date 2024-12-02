<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyFee extends Model
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function feeType(): BelongsTo
    {
        return $this->belongsTo(CompanyFeeType::class);
    }
}
