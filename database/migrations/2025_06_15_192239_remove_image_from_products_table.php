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
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom image lama
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
            
            // Tambah audit trail
            if (!Schema::hasColumn('products', 'created_by')) {
                $table->unsignedBigInteger('created_by')->after('price');
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
                
                $table->foreign('created_by')->references('id')->on('users');
                $table->foreign('updated_by')->references('id')->on('users');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable();
            
            if (Schema::hasColumn('products', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
                $table->dropColumn(['created_by', 'updated_by']);
            }
        });
    }
};
