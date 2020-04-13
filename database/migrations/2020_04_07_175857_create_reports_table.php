<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category')->nullable(true)->default('N/A');
            $table->string('url')->nullable(true)->default('N/A');
            $table->string('where')->nullable(true)->default('N/A');
            $table->string('type')->nullable(true)->default('N/A');
            $table->string('description')->nullable(true)->default('N/A');
            $table->string('personal_data')->nullable(true)->default('N/A');
            $table->string('personal_details')->nullable(true)->default('N/A');
            $table->string('name')->nullable(true)->default('N/A');
            $table->string('surname')->nullable(true)->default('N/A');
            $table->string('email')->nullable(true)->default('N/A');
            $table->string('phone')->nullable(true)->default('N/A');
            $table->string('age')->nullable(true)->default('N/A');
            $table->string('gender')->nullable(true)->default('N/A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
