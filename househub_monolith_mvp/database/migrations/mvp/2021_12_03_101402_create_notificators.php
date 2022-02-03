<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateNotificators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificators', function (Blueprint $table) {
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->unsignedInteger('type_id')->nullable(false);
            $table->string('value');
            $table->timestamp('deleted_at')->nullable(true);

            $table->foreign('type_id')->references('id')->on('notificator_types')->onDelete('cascade');

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificators');
    }
}
