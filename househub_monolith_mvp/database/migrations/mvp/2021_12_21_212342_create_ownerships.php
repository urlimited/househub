<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('real_estate_id')->nullable(false);
            $table->unsignedInteger('user_id')->nullable(false);
            $table->boolean('is_main_ownership')->nullable(false)->default(false);
            $table->boolean('is_active')->nullable(false)->default(true);
            $table->timestamp('active_since')->nullable(false)->useCurrent();
            $table->timestamp('inactive_since')->nullable(true);

            $table->foreign('real_estate_id')->references('id')->on('real_estates');
            $table->foreign('user_id')->references('id')->on('users');

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
