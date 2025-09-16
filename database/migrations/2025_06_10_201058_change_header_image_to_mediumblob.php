<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Menggunakan DB statement untuk MySQL specific type
        DB::statement('ALTER TABLE articles MODIFY header_image MEDIUMBLOB');
        
        // Atau jika ingin cara Laravel (hasilnya mungkin berbeda tergantung driver database)
        // Schema::table('articles', function (Blueprint $table) {
        //     $table->binary('header_image')->nullable()->change();
        // });
    }

    public function down()
    {
        DB::statement('ALTER TABLE articles MODIFY header_image BLOB');
    }
};