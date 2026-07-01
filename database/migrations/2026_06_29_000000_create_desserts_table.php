<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     */
    public function up(): void
    {
        Schema::create('desserts', function (Blueprint $table) {
            $table->id('id_dessert');
            $table->string('gambar')->nullable();
            $table->string('nama_dessert');
            $table->text('komposisi');
            $table->decimal('harga', 12, 2);
            $table->string('kategori');
            $table->timestamps();
        });
    }

    /**
     */
    public function down(): void
    {
        Schema::dropIfExists('desserts');
    }
};
