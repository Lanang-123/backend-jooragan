<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_toko');
            $table->string('title')->default('');
            $table->string('images')->default('');
            $table->integer('price')->default(0);
            $table->string('sold')->default(0);
            $table->string('stock')->default(0);
            $table->double('rating')->default(0);
            $table->string('location')->default('');
            $table->text('description')->default('');
            $table->timestamps();

            $table->foreign('id_toko')->references('id')->on('tokos')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
