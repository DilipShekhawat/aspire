<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulePayment extends Model
{

    protected $table = 'scheduled_payments';
    protected $fillable = [
        'loan_id', 'payment_amount', 'payment_date', 'status',
    ];
}
