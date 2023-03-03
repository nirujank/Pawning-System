<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'nic',
        'passport',
        'customer_name',
        'address',
        'phone',
        'email',
        'article_name',
        'carratage_value',
        'value_per_gram',
        'gross_weight',
        'net_weight',
        'value',
    ];
}
