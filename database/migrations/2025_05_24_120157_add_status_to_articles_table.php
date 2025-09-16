<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('articles', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            
            if (!Schema::hasColumn('articles', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
            
            if (!Schema::hasColumn('articles', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable();
            }
            
            if (!Schema::hasColumn('articles', 'reviewed_by')) {
                $table->unsignedBigInteger('reviewed_by')->nullable();
            }
            
            if (!Schema::hasColumn('articles', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            
            if (!Schema::hasColumn('articles', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable();
            }
        });

        // Tambah foreign key constraints setelah kolom dibuat
        Schema::table('articles', function (Blueprint $table) {
            // Cek apakah foreign key sudah ada
            $foreignKeys = collect(DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'articles' AND CONSTRAINT_NAME LIKE '%foreign%'"))->pluck('CONSTRAINT_NAME');
            
            if (!$foreignKeys->contains('articles_approved_by_foreign') && Schema::hasColumn('articles', 'approved_by')) {
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            }
            
            if (!$foreignKeys->contains('articles_reviewed_by_foreign') && Schema::hasColumn('articles', 'reviewed_by')) {
                $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop foreign keys safely
            $foreignKeys = collect(DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'articles' 
                AND CONSTRAINT_SCHEMA = DATABASE()
                AND CONSTRAINT_NAME LIKE '%foreign%'
            "))->pluck('CONSTRAINT_NAME');

            if ($foreignKeys->contains('articles_approved_by_foreign')) {
                $table->dropForeign(['approved_by']);
            }

            if ($foreignKeys->contains('articles_reviewed_by_foreign')) {
                $table->dropForeign(['reviewed_by']);
            }

            // Drop columns if they exist
            $columnsToRemove = ['status', 'rejection_reason', 'approved_by', 'reviewed_by', 'approved_at', 'reviewed_at'];
            $existingColumns = array_filter($columnsToRemove, function ($column) {
                return Schema::hasColumn('articles', $column);
            });

            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }

};
