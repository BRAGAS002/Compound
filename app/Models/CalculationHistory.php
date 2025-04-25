<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    protected $table = 'calculation_history';
    
    protected $fillable = [
        'principal',
        'rate',
        'time',
        'compounding_frequency',
        'start_date',
        'final_amount',
        'total_interest'
    ];

    protected $casts = [
        'principal' => 'decimal:2',
        'rate' => 'decimal:2',
        'time' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'total_interest' => 'decimal:2',
        'start_date' => 'date'
    ];
}
