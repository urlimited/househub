<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanyStatusHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_status_histories', function (Blueprint $table) {
            $table->efficientUuid('id', 16)->default(DB::raw('(UUID_TO_BIN(UUID()))'));
            $table->efficientUuid('company_id', 16)->nullable(false);
            $table->unsignedInteger('status_id')->nullable(false);
            $table->timestamp('saved_at')->nullable(false)->useCurrent();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('company_statuses');

            $table->primary('id');
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_status_histories');
    }
}
