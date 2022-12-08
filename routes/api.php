<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/register', 'Auth\UserAuthController@register');
Route::post('/login', 'Auth\UserAuthController@login');

Route::group(['middleware' => ['auth:api', 'checkCustomer'], 'prefix' => 'customer'], function () {
    Route::post('/create_loan', 'Customer\LoanController@create_loan');
    Route::get('/show_loan/{loan_id}', 'Customer\LoanController@show_loan');
    Route::post('/schedule_payment', 'Customer\LoanController@schedule_payment');
});
Route::group(['middleware' => ['auth:api', 'checkAdmin'], 'prefix' => 'admin'], function () {
    Route::get('/approve_loan/{loan_id}', 'Admin\AdminLoanController@approve_loan');
});
