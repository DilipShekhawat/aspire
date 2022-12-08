<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Models\SchedulePayment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $employees = Loan::all();
        return response(['employees' => LoanResource::collection($employees),
            'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\LoanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create_loan(LoanRequest $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'total_amount' => 'required',
                'term' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(),
                    'Validation Error']);
            }
            $data['apply_date'] = date('Y-m-d H:i:s');
            $data['user_id'] = auth()->user()->id;
            $loan = Loan::create($data);
            return response(['loan' => new LoanResource($loan),
                'message' => 'Success'], 200);
        } catch (Exception $e) {
            print_r("Migration Error in --- CreateLoan Functionality -- Controller --->\n" . $e);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_loan($id)
    {
        try {
            $loan = Loan::select('*')->with('schedulePayment')->where('id', $id)->first();
            return response(['loan' => $loan,
                'message' => 'Successful'], 200);
        } catch (Exception $e) {
            print_r("Migration Error in --- ShowLoan Functionality -- Controller --->\n" . $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function schedule_payment(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'user_id' => 'required',
                'loan_id' => 'required',
                'date' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors(),
                    'Validation Error']);
            }
            $exits = Loan::where('user_id', $request->user_id)->where('id', $request->loan_id)->first();
            if (!empty($exits)) {
                $installment = SchedulePayment::where('loan_id', $request->loan_id)->where('payment_date', $request->date)->first();
                if ($installment->payment_amount == $request->amount) {
                    if ($installment->payment_amount == 'PAID') {
                        $record = SchedulePayment::find($installment->id);
                        $record->status = 'PAID';
                        $record->save();
                        return response(['loan' => new LoanResource($record),
                            'message' => 'Installment Paid'], 200);
                    } else {
                        return response(['loan' => new LoanResource($installment),
                            'message' => 'Installment Already Paid'], 200);
                    }
                }
            }
        } catch (Exception $e) {
            print_r("Migration Error in --- Schedule Payment Functionality -- Controller --->\n" . $e);
        }

    }
}
