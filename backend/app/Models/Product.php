<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'old_price',
        'rating',
        'sold',
        'color',
        'emoji',
        'desc',
    ];

    protected $casts = [
        'price' => 'integer',
        'old_price' => 'integer',
        'rating' => 'decimal:1',
    ];
}
