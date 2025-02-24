<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'price',
        'start_date',
        'end_date',
        'active',
        'market_id',
    ];
}
