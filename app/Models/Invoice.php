<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'partner_id',
        'date_time',
        'total_value',
        'comment',
        'type',
        'status'
      ];
}
