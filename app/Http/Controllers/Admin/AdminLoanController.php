<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Repositories\LoanRepository;
use Exception;
use Illuminate\Http\Request;

class AdminLoanController extends Controller
{

    /**
     * @var Repository
     */
    protected $model;
    /**
     * ExamBoardController constructor.
     * @param Loan $model
     */
    public function __construct(Loan $model)
    {
        $this->model = new LoanRepository($model);
    }
    /**
     * Approve Loan Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve_loan($id)
    {
        try {
            $record = Loan::find($id);
            if ($record->status == 'PENDING') {
                $record->status = 'APPROVED';
                $record->save();
                $this->model->CalculatePayment($record);
                return response(['loan' => new LoanResource($record),
                    'message' => 'Success'], 200);
            } else {
                return response(['loan' => new LoanResource($record),
                    'message' => 'Loan already approved'], 200);
            }
        } catch (Exception $e) {
            print_r("Migration Error in --- ApproveLoan Functionality -- Controller --->\n" . $e);
        }
    }
}
