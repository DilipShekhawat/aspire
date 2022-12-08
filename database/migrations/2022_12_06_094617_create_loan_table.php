<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            try {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->decimal('total_amount');
                $table->bigInteger('term');
                $table->date('apply_date');
                $table->enum('status', ['PENDING', 'PAID', 'APPROVED'])->default('PENDING');
                $table->date('created_at');
                $table->date('updated_at');
            } catch (Exception $e) {
                print_r("Migration Error in --- CreateLoanTable -- UP --->\n" . $e);
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
            Schema::dropIfExists('loan');
        } catch (Exception $e) {
            print_r("Migration Error in --- DropLoanTable -- Down --->\n" . $e);
        }
    }
}
