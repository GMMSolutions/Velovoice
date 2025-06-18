<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->enum('status', ['Indépendant', 'Société']);
            $table->string('society')->nullable();
            $table->string('street');
            $table->string('CP');
            $table->string('street_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
