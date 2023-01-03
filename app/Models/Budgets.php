<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budgets extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'user_name',
        'total',
        'number',
        'low_stock',
        'created_at',
        'updated_at',
    ];

}
