<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    protected $connection = 'mongodb';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->string('card_holder');
            $table->datetime('expiry');
            $table->string('cvc')->nullable();
            $table->float('amount');
            $table->foreignId('user_id');
            $table->string('charge_id');
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
        Schema::connection('mongodb')->dropIfExists('payments');
    }
}
