<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSbrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sbr', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_price')->nullable();
            $table->string('provider_date')->nullable();
            $table->string('budget_price')->nullable();
            $table->string('budget_sale_price')->nullable();
            $table->string('budget_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sbr');
    }
}
