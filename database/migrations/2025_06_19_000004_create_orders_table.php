<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->double('unit_price');
            $table->timestamps();

            // Prevent duplicate entries for the same product in an invoice
            $table->unique(['invoice_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
