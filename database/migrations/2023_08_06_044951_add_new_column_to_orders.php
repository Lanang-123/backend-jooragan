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
        Schema::table('orders', function (Blueprint $table) {
            $table->text('alamat')->nullable();
            $table->string('no_hp', 100)->nullable();
            $table->string('no_inv', 100)->nullable();
            $table->enum('status_konfirmasi', ['terima', 'tolak']);
            $table->unsignedBigInteger('id_user');

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->dropColumn('no_hp');
            $table->dropColumn('no_inv');
            $table->dropForeign('id_user');
        });
    }
};
