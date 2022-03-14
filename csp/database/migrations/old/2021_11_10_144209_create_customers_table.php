<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->boolean("status")->default(false)->comment("Dürüm: 0-pasif 1-aktif");

            //Genel bilgileri
            $table->string('name')->comment("giriş yapacak kullanıcının adı	");
            $table->string("surname")->comment("giriş yapacak kullanıcının soyadı");
            $table->date("birth_date")->comment("Doğum tarihi");
            $table->string("gender")->comment("1-Erkek 2-Kadın");
            $table->string('email')->unique()->comment("giriş yapacak kullanıcının benzersiz eposta adresi");
            $table->string("phone")->comment("giriş yapacak kullanıcının telefon numarası");
            $table->string("work")->nullable()->comment("Kullanıcının Mesleği");
            $table->string("image")->nullable()->comment("giriş yapacak kullanıcının resmi");

            //Adres bilgileri
            $table->string("province")->nullable();
            $table->string("district")->nullable();
            $table->string("neighborhood")->nullable();
            $table->string("address")->nullable()->comment("Adres");

            //Social Media
            $table->string("facebook")->nullable()->comment("facebook linki");
            $table->string("instagram")->nullable()->comment("instagram linki");
            $table->string("twitter")->nullable()->comment("twitter linki");

            //Şifre
            $table->string('password')->comment("şifresi");
            $table->rememberToken();
           
            $table->text("description")->nullable()->comment("giriş yapacak kullanıcının açıklaması");
            $table->date("created_date")->nullable()->comment("oluşturma tarihi");
            $table->unsignedInteger("user_id")->comment("Kim eklemiş?");
            $table->unsignedInteger("update_user_id")->nullable()->comment("Kayıtı günceleyen kullanıcının idsi");
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
        Schema::dropIfExists('customers');
    }
}
