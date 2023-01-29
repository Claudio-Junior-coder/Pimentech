<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsObsOthersTaxesInSbrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sbrs', function (Blueprint $table) {
            //
            $table->string('other_taxes')->default(0);
            $table->string('obs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sbrs', function (Blueprint $table) {
            //
        });
    }
}
