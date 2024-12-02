<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulesTable extends Migration
{
    public function up()
    {
        Schema::create(config('permissioning.database.table', 'rules'), function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('action');
            $table->json('conditions');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('permissioning.database.table', 'rules'));
    }
}