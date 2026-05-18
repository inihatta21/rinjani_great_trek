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
        Schema::table('paket', function (Blueprint $table) {
            $table->string('nama_paket_en', 100)->nullable()->after('nama_paket');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
            $table->text('itinerary_en')->nullable()->after('itinerary');
        });

        Schema::table('artikel', function (Blueprint $table) {
            $table->string('judul_artikel_en')->nullable()->after('judul_artikel');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn(['judul_artikel_en', 'deskripsi_en']);
        });

        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn(['nama_paket_en', 'deskripsi_en', 'itinerary_en']);
        });
    }
};
