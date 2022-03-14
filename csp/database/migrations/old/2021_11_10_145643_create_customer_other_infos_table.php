<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOtherInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_other_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("customer_id")->comment("Müsteri si");
            $table->unsignedBigInteger("find_us_id")->nullable()->comment("Bizi nereden buldunuz idsi");
            $table->text("description")->nullable()->comment("Kısa açıklama");
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
        Schema::dropIfExists('customer_other_infos');
    }
}
