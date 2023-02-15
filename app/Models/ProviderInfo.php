<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'telephone',
        'telephone_two',
        'description',
        'add_number',
        'cep',
        'zone',
        'city',
        'state',
        'email',
        'cnpj',
        'contact',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
