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
        Schema::create('stok_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('no_faktur')->unique();
            $table->foreignId('item_id')->references('id')->on('items');
            $table->foreignId('supplier_id')->references('id')->on('suppliers');
            $table->integer('jumlah');
            $table->bigInteger('harga');
            $table->bigInteger('bayar');
            $table->integer('kembali');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_histories');
    }
};
