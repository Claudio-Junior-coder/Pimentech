<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBudgetHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_histories', function (Blueprint $table) {
            //
            $table->string('customer_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('total')->nullable();
            $table->integer('low_stock')->default(0);
            $table->string('number')->default(0);
            $table->string('condition_payment')->nullable();
            $table->string('inspection')->nullable();
            $table->string('address_to_shipping')->nullable();
            $table->string('time')->nullable();
            $table->string('price_in_string')->nullable();
            $table->string('customer_a_c')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_address_to_shipping')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_cnpj')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_state')->nullable();
            $table->integer('pdf_was_generated')->default(0);
            $table->string('second_customer_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_histories', function (Blueprint $table) {
            //
        });
    }
}
