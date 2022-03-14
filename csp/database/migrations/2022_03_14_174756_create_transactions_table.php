<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("unique_id");
            $table->string("user_unique_id");
            $table->integer("operator")->comment("1-orange, 2-telma, 3-airtel");
            $table->string("recipient_number");
            $table->integer("type")->comment("1-depot, 2-retrait");
            $table->decimal("amount");
            $table->double("bonus")->nullable();
            $table->date("added_at")->comment("date de la transaction");
            $table->time("time")->comment("heure de la transaction");
            $table->tinyInteger("status")->default(1)->comment("1-paid 2-pending 3-cancelled");
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
        Schema::dropIfExists('transactions');
    }
}
