<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaitentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('gender', array('Male', 'Female' , 'Other'))->nullable()->after('contact_id');
            $table->string('birth_date')->nullable()->after('gender');
            $table->integer('age')->nullable()->after('birth_date');
            $table->enum('blood_group', array('A+','A-','B+','AB+','AB-','B-','O+','O-'))->nullable()->after('age');
            $table->enum('marital_status', array('single', 'married' , 'other'))->after('blood_group');
            $table->integer('ref_by')->unsigned()->nullable()->after('marital_status');
            $table->string('image')->nullable()->after('ref_by');
            $table->foreign('ref_by')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
