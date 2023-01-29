<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'brand',
        'name',
        'um',
        'diameter',
        'quantity',
        'price',
        'weight',
        'draft',
        'cod',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
