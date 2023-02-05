<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone',
        'company_cnpj',
        'company_insc',
        'company_insc_municip',
        'company_email',
        'budget_number',
        'charge_date',
        'updated_at',
        'deleted_at',
    ];
}
