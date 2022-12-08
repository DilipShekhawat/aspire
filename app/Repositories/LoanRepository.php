<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Models\SchedulePayment;

class LoanRepository extends Repository
{
/**
 * Constructor function
 * @param Loan $model
 */
    public function __construct(Loan $model)
    {
        $this->model = $model;
    }

    public function CalculatePayment($data)
    {
        $amount = 0;
        $scheduledPayment = round($data['total_amount'] / $data['term'], 2);
        for ($i = 0; $i < $data['term']; $i++) {
            $amount += $scheduledPayment;
            if ($i == $data['term'] - 1) {
                $last_adjust_amount = $data['total_amount'] - $amount;
                $scheduledPayment = $scheduledPayment + $last_adjust_amount;
            }
            $date = $this->paymentDate($data['term']);
            $record['loan_id'] = $data['id'];
            $record['payment_amount'] = $scheduledPayment;
            $record['payment_date'] = $date[$i];
            $loan = SchedulePayment::create($record);
        }
        return true;
    }

    public function paymentDate($term)
    {
        $days = 7;
        $currentDate = date('Y-m-d');
        for ($i = 0; $i < $term; $i++) {
            $date[] = date('Y-m-d', strtotime($currentDate . ' + ' . $days . ' days'));
            $days = $days + $days;
        }
        return $date;
    }
}
