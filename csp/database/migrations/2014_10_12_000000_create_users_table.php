<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("unique_id");
            $table->string("identity_number")->nullable()->comment("CIN");
            $table->boolean("status")->default(true)->comment("Dürüm: 0-pasif 1-akcif");
            $table->string("permission")->default(3)->comment("1->Admin | 2->Personel");
            $table->date("started_at")->nullable()->useCurrent()->comment("starting to use the system");
            $table->date("finished_at")->nullable()->comment("last date to use the system");
            
            //Genel bilgileri
            $table->string('name');
            $table->string("surname");
            $table->date("birth_date")->nullable();
            $table->string("gender")->nullable();
            $table->string('email')->unique();
            $table->string("phone");
            $table->string("image")->nullable()->comment("picture profile");

            //operator
            $table->string("orange")->unique()->nullable()->comment("phone number for orange money");
            $table->string("telma")->unique()->nullable()->comment("phone number for telma money");
            $table->string("airtel")->unique()->nullable()->comment("phone number for airtel money");

            //Adres bilgileri
            $table->string("province")->nullable();
            $table->string("district")->nullable();
            $table->string("neighborhood")->nullable();
            $table->string("akondro")->nullable();
            $table->string("address")->nullable()->comment("Adres");

            //Social Media
            $table->string("facebook")->nullable()->comment("facebook link");
            $table->string("instagram")->nullable()->comment("instagram link");
            $table->string("twitter")->nullable()->comment("twitter link");

            //Şifre
            $table->string('password')->comment("şifresi");
            $table->rememberToken();
            $table->text("description")->nullable();
            $table->unsignedInteger("user_id")->comment("added by user");

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
        Schema::dropIfExists('users');
    }
}
