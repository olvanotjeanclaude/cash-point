<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->boolean("type")->comment("Merkezde mi?");
            $table->string("name")->comment("Merkezin adı");
            $table->string("phone")->comment("Telefon numara");
            $table->string("email")->comment("Şübenin epostası");
           //Adres bilgileri
           $table->string("province")->nullable()->comment("İl");
           $table->string("district")->nullable()->comment("İlçe");
           $table->string("neighborhood")->nullable()->comment("Mahalle");
           $table->string("address")->nullable()->comment("Açık Adres");
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
        Schema::dropIfExists('branches');
    }
}
