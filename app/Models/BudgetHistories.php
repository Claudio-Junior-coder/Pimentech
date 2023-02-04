<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'action',
        'before_info',
        'current_info',
        'made_by',
        'created_at',
        'updated_at',
    ];

}
