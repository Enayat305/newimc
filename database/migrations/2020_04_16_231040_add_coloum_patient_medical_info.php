<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumPatientMedicalInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_diets', function (Blueprint $table) {
            $table->boolean('check_box')->default(0)->after('diet_id');

        });
        Schema::table('patient_family_histories', function (Blueprint $table) {
            $table->boolean('check_box')->default(0)->after('family_history_id');

        });
        Schema::table('patient_allergies', function (Blueprint $table) {
            $table->boolean('check_box')->default(0)->after('allergie_id');

        });
        Schema::table('patient_pathlogies', function (Blueprint $table) {
            $table->boolean('check_box')->default(0)->after('pathologicalhistory_id');

        });
        Schema::table('patient_phychiatrichistories', function (Blueprint $table) {
            $table->boolean('check_box')->default(0)->after('phychiatrichistorie_id');

        });
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->boolean('check_box')->default(0)->after('vaccines_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
