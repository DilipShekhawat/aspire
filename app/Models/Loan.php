<?php

namespace App\Models;

use App\Models\SchedulePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_amount', 'term', 'apply_date', 'status',
    ];

    public function schedulePayment()
    {
        return $this->hasMany(SchedulePayment::class, 'loan_id', 'id');
    }
}
