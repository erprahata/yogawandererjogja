<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Users (Modifikasi tabel default Laravel)
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('password');
        });

        // Tabel Yoga Classes
        Schema::create('yoga_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('schedule');
            $table->decimal('price', 10, 2);
            $table->integer('quota');
            $table->timestamps();
        });

        // Tabel Transactions / Bookings
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('yoga_class_id')->constrained('yoga_classes')->cascadeOnDelete();
            $table->string('transaction_code')->unique();
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('payment_method')->default('manual_transfer');
            $table->string('qr_code_path')->nullable();
            $table->boolean('is_attended')->default(false); // Untuk fitur Check-in Hari H
            $table->timestamps();
        });

        // Tabel CMS Landing Page (Sponsorship/Brand Collabs)
        Schema::create('cms_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // cth: 'hero', 'sponsorship'
            $table->string('key')->unique(); // cth: 'hero_title', 'sponsor_logo_1'
            $table->text('value'); // Menyimpan teks atau path URL gambar
            $table->enum('type', ['text', 'image'])->default('text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_contents');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('yoga_classes');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'role']);
        });
    }
};
