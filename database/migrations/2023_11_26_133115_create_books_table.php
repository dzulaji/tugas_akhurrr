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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code');
            $table->string('cover')->nullable();
            $table->string('author');
            $table->string('year');         // Tahun terbit
            $table->string('publisher');
            $table->string('description');
            $table->foreignId('category_id');
            $table->integer('stock');
            $table->integer('pages');       // Jumlah halaman
            $table->string('language');     // Bahasa
            $table->string('isbn_issn');    // ISBN/ISSN
            $table->string('content_type'); // Tipe Isi
            $table->string('media_type');   // Tipe Media
            $table->string('carrier_type'); // Tipe Pembawa
            $table->string('edition');      // Edisi
            $table->string('subject');      // Subjek
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
