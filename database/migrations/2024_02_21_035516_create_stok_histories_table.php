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
            $table->bigInteger('no_faktur')->unique()->nullable();
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->integer('jumlah');
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('bayar')->nullable();
            $table->integer('kembali')->nullable();
            $table->string('keterangan');
            $table->date('tanggal');
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
