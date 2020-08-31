<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestParticularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_particulars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_head_id')->unsigned();
            $table->foreign('report_head_id')->references('id')->on('report_heads')->onDelete('cascade');
            $table->string('name');
            $table->string('result')->nullable();
            $table->string('unit')->nullable();
            $table->string('male')->nullable();
            $table->string('female')->nullable();
            $table->string('high_range')->nullable();
            $table->string('low_range')->nullable();
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
        Schema::dropIfExists('test_particulars');
    }
}
