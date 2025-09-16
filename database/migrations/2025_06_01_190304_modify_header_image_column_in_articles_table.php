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
        Schema::table('articles', function (Blueprint $table) {
            // CEK APAKAH KOLOM header_image ADA SEBELUM RENAME
            if (Schema::hasColumn('articles', 'header_image')) {
                // Jika ada kolom header_image, rename ke header_image_path
                $table->renameColumn('header_image', 'header_image_path');
            } else {
                // Jika tidak ada, buat kolom header_image_path untuk backup
                $table->string('header_image_path')->nullable();
            }
        });

        // Setelah rename/create, tambah kolom baru
        Schema::table('articles', function (Blueprint $table) {
            // Tambah kolom baru untuk BLOB data (longText untuk base64)
            if (!Schema::hasColumn('articles', 'header_image')) {
                $table->longText('header_image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop kolom header_image yang baru
            if (Schema::hasColumn('articles', 'header_image')) {
                $table->dropColumn('header_image');
            }
            
            // Jika ada header_image_path, rename kembali ke header_image
            if (Schema::hasColumn('articles', 'header_image_path')) {
                $table->renameColumn('header_image_path', 'header_image');
            }
        });
    }
};