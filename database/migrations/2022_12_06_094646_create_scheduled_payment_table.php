<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_payments', function (Blueprint $table) {
            try {
                $table->id();
                $table->unsignedBigInteger('loan_id');
                $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade')->onUpdate('cascade');
                $table->decimal('payment_amount');
                $table->date('payment_date');
                $table->enum('status', ['PENDING', 'PAID'])->default('PENDING');
                $table->date('created_at');
                $table->date('updated_at');
            } catch (Exception $e) {
                print_r("Migration Error in --- CreateScheduledPaymentTable -- UP --->\n" . $e);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::dropIfExists('scheduled_payment');
        } catch (Exception $e) {
            print_r("Migration Error in --- DropScheduledPaymentTable -- Down --->\n" . $e);
        }
    }
}
