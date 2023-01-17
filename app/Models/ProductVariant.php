<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    protected $fillable = [
        'variant', 'variant_id', 'product_id'
    ];

    public function variantPrices(){
        return $this->hasMany(ProductVariantPrice::class,'product_variant_one','id');
    }
}
