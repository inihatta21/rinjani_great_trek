<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->string('kategori', 50)->default('Umum')->after('nama_paket_en');
        });

        DB::table('paket')
            ->whereNull('kategori')
            ->update(['kategori' => 'Umum']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
