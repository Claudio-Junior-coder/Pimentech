<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('products', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('providers', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('budgets', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            //
            $table->softDeletes();
        });

        Schema::table('provider_info', function (Blueprint $table) {
            //
            $table->softDeletes();
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
