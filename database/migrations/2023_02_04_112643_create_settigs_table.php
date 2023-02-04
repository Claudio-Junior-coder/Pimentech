<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('settings')->insert(
            [
                array(
                    'setting' => 'company_name',
                    'value' => ''
                ),
                array(
                    'setting' => 'company_address',
                    'value' => ''
                ),
                array(
                    'setting' => 'company_phone',
                    'value' => ''
                ),
                array(
                    'setting' => 'company_cnpj',
                    'value' => ''
                ),
                array(
                    'setting' => 'company_insc',
                    'value' => ''
                ),
                array(
                    'setting' => 'company_insc_municip',
                    'value' => ''
                ),
                array(
                    'setting' => 'company_email',
                    'value' => ''
                ),
                array(
                    'setting' => 'budget_number',
                    'value' => date('Y') . '01'
                ),
                array(
                    'setting' => 'charge_date',
                    'value' => ''
                )
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settigs');
    }
}
