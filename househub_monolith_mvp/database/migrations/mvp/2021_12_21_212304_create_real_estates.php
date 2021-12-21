<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealEstates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estates', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('address')->nullable(false);
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('parent_id')->nullable(true);
            $table->unsignedInteger('type_id')->nullable(false);

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('parent_id')->references('id')->on('real_estates');
            $table->foreign('type_id')->references('id')->on('real_estate_types');

            $table->index('parent_id');
            $table->index('type_id');
            $table->index('city_id');
            $table->index('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estates');
    }
}
