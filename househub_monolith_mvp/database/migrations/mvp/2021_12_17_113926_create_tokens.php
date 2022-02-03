<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->text('value')->nullable(false);
            $table->unsignedInteger('type_id')->nullable(false);
            $table->efficientUuid('user_id', 16)->nullable(false);
            $table->timestamp('saved_at')->nullable(false)->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('token_types');

            $table->primary('id');
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
        Schema::dropIfExists('tokens');
    }
}
