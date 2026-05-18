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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->text('nama_kategori');
            $table->timestamps();
        });

        Schema::table('paket', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_id')->nullable()->after('kategori');
            $table->foreign('kategori_id')->references('id')->on('kategori')->nullOnDelete();
            $table->index('kategori_id');
        });

        $kategoriNames = DB::table('paket')
            ->select('kategori')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori');

        foreach ($kategoriNames as $name) {
            DB::table('kategori')->insert([
                'nama_kategori' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $kategoriMap = DB::table('kategori')
            ->pluck('id', 'nama_kategori');

        foreach ($kategoriMap as $name => $id) {
            DB::table('paket')
                ->where('kategori', $name)
                ->update(['kategori_id' => $id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropIndex(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::dropIfExists('kategori');
    }
};
