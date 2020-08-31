<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription__histories', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('prescription_id')->unsigned();
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('body_mass')->nullable();
            $table->integer('temperature')->nullable();
            $table->integer('respiratory_rate')->nullable(); 
            $table->integer('systole')->nullable();
            $table->integer('diastole')->nullable();
            $table->integer('heart_rate')->nullable();
            $table->string('body_fat_per')->nullable();
            $table->integer('lean_body_mass')->nullable();
            $table->integer('head_circumference')->nullable();
            $table->integer('oxygen_saturiation')->nullable();  
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
        Schema::dropIfExists('prescription__histories');
    }
}
