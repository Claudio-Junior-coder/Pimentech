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
        'condition_payment',
        'inspection',
        'address_to_shipping',
        'time',
        'price_in_string',
        'low_stock',
        'customer_a_c',
        'customer_city',
        'customer_address_to_shipping',
        'customer_phone',
        'customer_cnpj',
        'customer_email',
        'customer_state',
        'pdf_was_generated',
        'second_customer_phone',
        'created_at',
        'updated_at',
    ];

}
