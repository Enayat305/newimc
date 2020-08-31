<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumToTestsSell extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        
        DB::statement("ALTER TABLE test_particulars MODIFY COLUMN name Varchar(250)  DEFAULT Null");
        Schema::table('report_heads', function (Blueprint $table) {
            $table->boolean('is_show')->default(1);

            
        });
        DB::statement("ALTER TABLE cash_register_transactions MODIFY COLUMN transaction_type ENUM('initial', 'sell', 'transfer', 'refund','lab_sell')");
        
        
        Schema::table('transactions', function (Blueprint $table) {

        $table->enum('spicemen', ['Taking_In_Lab', 'Brought_To_Lab'])->default('Taking_In_Lab')->after('doctor_id');
        
        });            
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests_sell', function (Blueprint $table) {
            //
        });
    }
}
