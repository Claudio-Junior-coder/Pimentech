<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone',
        'cnpj',
        'phone',
        'insc',
        'insc_municip',
        'email',
        'created_at',
        'updated_at',
    ];
}
