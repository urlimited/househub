<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRealEstateAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_attributes', function (Blueprint $table) {
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->efficientUuid('real_estate_id', 16)->nullable(false);
            $table->string('key')->nullable(false);
            $table->string('value')->nullable(true);

            $table->foreign('real_estate_id')->references('id')->on('real_estates')
                ->onDelete('cascade');

            $table->primary('id');
            $table->index('real_estate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_attributes');
    }
}
