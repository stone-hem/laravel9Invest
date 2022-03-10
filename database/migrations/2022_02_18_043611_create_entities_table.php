<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('directorName');
            $table->string('entityName');
            $table->string('entityPhoneNumber');
            $table->string('entityKraPin');
            $table->string('email');
            $table->string('entityAddress');
            $table->string('entitySector');
            $table->string('entityRegNumber');
            $table->string('regDocs');
            $table->unsignedBigInteger('user_id');
            $table->string('businessPermit');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
};
