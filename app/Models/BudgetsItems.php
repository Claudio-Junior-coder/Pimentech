<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetsItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'product_id',
        'provider_name',
        'product_name',
        'quantity',
        'price',
        'total_price',
        'created_at',
        'updated_at',
    ];

}
