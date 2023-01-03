<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'a_c',
        'city',
        'address_to_shipping',
        'phone',
        'cnpj',
        'email',
        'state',
        'draft',
        'created_at',
        'updated_at',
    ];
}
