<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->string('name')->nullable(false);
            $table->string('bin')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('website')->nullable(true);
            $table->string('comments')->nullable(true);
            $table->unsignedInteger('type_id')->nullable(false);

            $table->foreign('type_id')->references('id')->on('company_types')->onDelete('set default');

            $table->primary('id');
            $table->index('name');
            $table->index('bin');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
