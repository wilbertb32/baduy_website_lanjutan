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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Nama file asli
            $table->string('mime_type'); // image/jpeg, image/png, dll
            $table->integer('size'); // Ukuran file dalam bytes
            $table->longText('image_data'); // Data gambar dalam base64 format
            
            // Polymorphic relationship columns
            $table->string('imageable_type'); // App\Models\User, App\Models\Article, dll
            $table->unsignedBigInteger('imageable_id'); // ID dari model tersebut
            
            // Audit trail
            $table->unsignedBigInteger('uploaded_by'); // Admin/User yang upload
            $table->string('image_type')->default('main'); // main, gallery, thumbnail, profile, header
            $table->integer('order')->default(0); // Urutan gambar (untuk gallery)
            
            $table->timestamps();
            
            // Foreign key dan indexes
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['imageable_type', 'imageable_id'], 'polymorphic_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
