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
        'article_details',
    ];

    protected $casts = ['article_details' => 'array'];
}
