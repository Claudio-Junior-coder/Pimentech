<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewsColumnInBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {            //

            $table->string('customer_a_c')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_address_to_shipping')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_cnpj')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {
            //
        });
    }
}
