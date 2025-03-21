<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // The fields that can be mass assigned
    protected $fillable = [
        'product_code',
        'quantity',
    ];
}
