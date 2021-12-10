<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_codes', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('code')->nullable(false);
            $table->unsignedInteger('type_id')->nullable(false);
            $table->unsignedInteger('user_id')->nullable(false);
            $table->unsignedInteger('notificator_id')->nullable(false);
            $table->timestamp('sent_at')->nullable(false)->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('auth_code_types');
            $table->foreign('notificator_id')->references('id')->on('notificators');

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
        Schema::dropIfExists('auth_codes');
    }
}
