<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOwnerships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ownerships', function (Blueprint $table) {
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->efficientUuid('real_estate_id', 16)->nullable(false);
            $table->efficientUuid('user_id', 16)->nullable(false);
            $table->boolean('is_main_ownership')->nullable(false)->default(false);
            $table->boolean('is_active')->nullable(false)->default(true);
            $table->timestamp('active_since')->nullable(false)->useCurrent();
            $table->timestamp('inactive_since')->nullable(true);

            $table->foreign('real_estate_id')->references('id')->on('real_estates');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary('id');
            $table->index('real_estate_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ownerships');
    }
}
