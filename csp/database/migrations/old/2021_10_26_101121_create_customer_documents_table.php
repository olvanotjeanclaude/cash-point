<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("type")->comment("1-Kimlik 2-sözleşme 3-Diğer");
            $table->string('docTitle')->comment('dökuman başlık');
            $table->string('docFileUrl')->comment('dökuman url');
            $table->unsignedInteger("client_id")->comment("Müsteri id si");
            $table->integer('user_id')->comment('sisteme kim eklemiş');
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
        Schema::dropIfExists('customer_documents');
    }
}
