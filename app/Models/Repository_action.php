<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository_action extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'count',
        'price',
        'invoice_id'
    ];
}
