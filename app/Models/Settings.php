<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_email',
        'budget_number',
        'charge_date',
        'company_name',
        'updated_at',
        'deleted_at',
    ];
}
