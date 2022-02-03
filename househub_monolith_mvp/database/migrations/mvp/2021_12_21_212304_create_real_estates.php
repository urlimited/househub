<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->string('address')->nullable(false);
            $table->unsignedInteger('city_id')->nullable(false);
            $table->efficientUuid('parent_id', 16)->nullable(true)->default(null);
            $table->unsignedInteger('type_id')->nullable(false);
            $table->timestamp('deleted_at')->nullable(true);

            $table->primary('id');
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
