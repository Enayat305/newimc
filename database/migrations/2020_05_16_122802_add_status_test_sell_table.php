<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusTestSellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_sells', function (Blueprint $table) {
            $table->string('status')->after('test_result');
            $table->string('invoice_token')->nullable();
            $table->string('file')->nullable()->after('test_result');
            $table->dateTime('report_date')->after('test_result');
            $table->dateTime('reported_dated')->nullable()->after('test_result');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_sells', function (Blueprint $table) {
            //
        });
    }
}
