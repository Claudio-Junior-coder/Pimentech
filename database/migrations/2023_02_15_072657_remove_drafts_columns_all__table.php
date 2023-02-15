<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDraftsColumnsAllTable extends Migration
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
            $table->dropColumn('draft');
        });
        Schema::table('companies', function (Blueprint $table) {
            //
            $table->dropColumn('draft');
        });
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->dropColumn('draft');
        });
        Schema::table('provider_infos', function (Blueprint $table) {
            //
            $table->dropColumn('draft');
        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('draft');
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
