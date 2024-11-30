<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'catalog_id',
        'code',
        'description',
        'active',
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    static function byCatalog($catalog_id)
    {
        return Catalog::find($catalog_id)->codes()->where('active', true)->get();
    }

    static function byCatalogOnlyCodes($catalog_id, $codes)
    {
        return Catalog::find($catalog_id)->codes()
            ->where('active', true)
            ->whereIn('code', $codes)
            ->get();
    }

    static function byCatalogAndCode($catalog_id, $code)
    {
        return Code::where('catalog_id', $catalog_id)
            ->where('code', $code)
            ->first();
    }

    static function IdByCatalogAndCode($catalog_id, $code)
    {
        $code = static::byCatalogAndCode($catalog_id, $code);
        return $code->id;
    }

    static function byCatalogAll($catalog_id)
    {
        return Catalog::find($catalog_id)->codes()->get();
    }

}
