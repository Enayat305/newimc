<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
           
                $table->increments('id');
                $table->string('name');
                $table->integer('department_id')->unsigned();
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
                $table->string('test_code');
                $table->string('sample_require');
                $table->string('carry_out')->nullable();
                $table->string('report_time_day')->nullable();
                $table->text('description')->nullable();
                $table->text('test_comment')->nullable();
                $table->decimal('final_total', 22, 4)->default(0);
                $table->decimal('test_cast_amount', 22, 4)->default(0);
                $table->decimal('more_amount', 22, 4)->default(0);
                $table->integer('business_id')->unsigned();
                $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
                $table->integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tests');
    }
}
