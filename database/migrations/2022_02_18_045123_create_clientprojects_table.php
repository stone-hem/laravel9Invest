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
        Schema::create('clientprojects', function (Blueprint $table) {
            $table->id();
            $table->string('projectName');
            $table->string('sector');
            $table->string('goalAmount');
            $table->string('myInvestment');
            $table->string('percentageStake')->default('null');
            $table->string('percentageCompletion')->default('null');
            $table->date('closingDate');
            $table->tinyInteger('equityDealType')->default(0);
            $table->tinyInteger('debtDealType')->default(0);
            $table->tinyInteger('revenueShareDealType')->default(0);
            $table->string('equityAmount');
            $table->string('debtAmount');
            $table->string('revuenueShareAmount');
            $table->tinyInteger('investAsPerson')->default(0);
            $table->tinyInteger('investAsLegalEntity')->default(0);
            $table->tinyInteger('agree')->default(0);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('clientprojects');
    }
};
