<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sells', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('test_id')->unsigned();
                $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
                $table->integer('transaction_id')->unsigned();
                $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
                $table->integer('patient_id')->unsigned();
                $table->foreign('patient_id')->references('id')->on('contacts')->onDelete('cascade');
                $table->integer('department_id')->unsigned();
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
                $table->integer('ref_by')->unsigned();
                $table->foreign('ref_by')->references('id')->on('users')->onDelete('cascade');
                $table->string('report_code');
                $table->text('test_comment')->nullable();
                $table->text('test_result')->nullable();
                $table->decimal('final_total', 22, 4)->default(0);
                $table->decimal('test_cast_amount', 22, 4)->default(0);
                $table->decimal('more_amount', 22, 4)->default(0);
                $table->softDeletes();
                $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_sells');
    }
}
