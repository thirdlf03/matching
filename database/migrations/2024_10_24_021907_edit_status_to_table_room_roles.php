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
        Schema::table('room_roles', function (Blueprint $table) {
            //
             //役割のステータスを管理
            $table->string('status')->nullable()->change();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_roles', function (Blueprint $table) {
            //
            
        });
    }
};
