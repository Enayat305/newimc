<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTestParticularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_test_particulars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('test_sell_id')->unsigned();
            $table->foreign('test_sell_id')->references('id')->on('test_sells')->onDelete('cascade');
            $table->integer('report_head_id')->unsigned();
            $table->foreign('report_head_id')->references('id')->on('report_heads')->onDelete('cascade');
            $table->string('invoice_token')->nullable();
            $table->string('result')->nullable();
            $table->string('unit')->nullable();
            $table->string('male')->nullable();
            $table->string('female')->nullable();
            $table->string('high_range')->nullable();
            $table->string('low_range')->nullable();
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
        Schema::dropIfExists('report_test_particulars');
    }
}
