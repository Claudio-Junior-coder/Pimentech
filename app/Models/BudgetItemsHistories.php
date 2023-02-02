<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItemsHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'product_id',
        'provider_name',
        'product_name',
        'quantity',
        'price',
        'um',
        'total_price',
        'created',
        'updated',
        'weight',
        'created_at',
        'updated_at',
    ];
}
