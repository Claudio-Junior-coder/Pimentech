<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDateToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
            Schema::table('budget_histories', function (Blueprint $table) {
                //
                $table->string('date')->default(date("d/m/Y"));
            });

            Schema::table('budgets', function (Blueprint $table) {
                //
                $table->string('date')->default(date("d/m/Y"));
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
}
