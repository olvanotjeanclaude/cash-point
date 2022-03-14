<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->dateTime("date_time")->comment("Görüşmenin saat ve tarihi");
            $table->unsignedInteger("user_id")->comment("Görüşmeyi ekleyen kullanıncın idsi");
            $table->unsignedInteger("customer_id")->comment("Müsterinin idsi");
            $table->text("description")->nullable()->comment("Kısa not");
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
        Schema::dropIfExists('meetings');
    }
}
