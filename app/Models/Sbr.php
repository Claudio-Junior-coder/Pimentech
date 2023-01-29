<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sbr extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'provider_id',
        'provider_price',
        'provider_date',
        'budget_price',
        'shipping_price',
        'cost_price',
        'profit_price',
        'budget_sale_price',
        'budget_date',
        'other_taxes',
        'obs',
        'budget_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
