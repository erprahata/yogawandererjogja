<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('yoga_classes', function (Blueprint $table) {
            // Tipe kelas: rutin atau event
            $table->enum('type', ['regular', 'event'])->default('regular')->after('description');
            
            // Kolom untuk kelas rutin (Array hari & Jam)
            $table->json('recurring_days')->nullable()->after('type'); // cth: ["Wednesday", "Saturday", "Sunday"]
            $table->time('start_time')->nullable()->after('recurring_days'); // cth: 06:00:00
            
            // Lokasi spesifik (opsional untuk reguler, wajib untuk event)
            $table->string('location')->nullable()->after('start_time');
            
            // Mengubah kolom schedule bawaan menjadi nullable (karena kelas reguler tidak butuh ini)
            $table->dateTime('schedule')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('yoga_classes', function (Blueprint $table) {
            $table->dropColumn(['type', 'recurring_days', 'start_time', 'location']);
            $table->dateTime('schedule')->nullable(false)->change();
        });
    }
};