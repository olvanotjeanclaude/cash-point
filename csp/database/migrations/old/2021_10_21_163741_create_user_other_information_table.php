<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOtherInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_other_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->comment("Müsteri veya kullanıcının id si");
            $table->tinyInteger("you_found_us")->nullable()->comment("1-website 2-sosyal medya:facebook,instagram 3-ziyaret 4-telefon görüşmesi");
            $table->text("description")->nullable()->comment("Kısa açıklama");
            //$table->tinyInteger("level_of_interest")->nullable()->comment("1-Kötü 2-Normal 3-iyi 4-Ciddi");
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
        Schema::dropIfExists('user_other_information');
    }
}
