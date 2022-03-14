<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_meetings', function (Blueprint $table) {
            $table->id();
            $table->dateTime("date_time")->comment("sonraki görüşme için Tarihi ve saat");
            $table->unsignedInteger("customer_id")->comment("Müsterinin idsi");
            $table->text("description")->nullable()->comment("Kısa not");
            $table->unsignedInteger("user_id")->comment("ekleyen Kullanıcının idsi");
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
        Schema::dropIfExists('income_meetings');
    }
}
