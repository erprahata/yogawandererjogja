<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\YogaClass;
use App\Models\CmsContent;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin & User Dummy
        $admin = User::firstOrCreate(
            ['email' => 'admin@rhtlabs.com'],
            ['name' => 'Coach Admin', 'password' => bcrypt('password'), 'role' => 'admin', 'phone_number' => '081234567890']
        );

        $customer1 = User::firstOrCreate(['email' => 'user1@mail.com'], ['name' => 'Erghi Pramudya', 'password' => bcrypt('password'), 'role' => 'customer', 'phone_number' => '0811111111']);
        $customer2 = User::firstOrCreate(['email' => 'user2@mail.com'], ['name' => 'Siska', 'password' => bcrypt('password'), 'role' => 'customer', 'phone_number' => '0822222222']);

        // 2. Buat Konten CMS Landing Page
        $cmsData = [
            ['section' => 'hero', 'key' => 'hero_title', 'value' => 'Yoga Wanderer Jogja', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'hero_subtitle', 'value' => 'Temukan keseimbangan batin melalui sesi yoga eksklusif di alam terbuka Yogyakarta.', 'type' => 'text'],
            ['section' => 'sponsorship', 'key' => 'sponsor_cta', 'value' => 'Hubungi Kemitraan', 'type' => 'text'],
            ['section' => 'hero', 'key' => 'hero_image_1', 'value' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=1920', 'type' => 'image'],
        ];
        foreach ($cmsData as $data) {
            CmsContent::updateOrCreate(['key' => $data['key']], $data);
        }

        // 3. Buat Kelas Yoga (Reguler & Event)
        $class1 = YogaClass::create([
            'name' => 'Sunset Hatha Routine',
            'description' => 'Kelas reguler untuk melepaskan stres harian. Cocok untuk semua level dengan panduan postur yang menenangkan.',
            'type' => 'regular',
            'recurring_days' => ['Wednesday', 'Saturday', 'Sunday'], // Array hari
            'start_time' => '16:30:00',
            'location' => 'Plataran Pelataran Candi',
            'price' => 75000,
            'quota' => 15
        ]);

        $class2 = YogaClass::create([
            'name' => 'Full Moon Yoga Retreat',
            'description' => 'Sesi meditasi dan Yin Yoga eksklusif di bawah cahaya purnama penuh. Kuota sangat terbatas untuk menjaga ketenangan.',
            'type' => 'event',
            'schedule' => Carbon::now()->addDays(14)->setTime(18, 30), // Tanggal pasti
            'location' => 'Hutan Pinus Mangunan (Secret Spot)',
            'price' => 250000,
            'quota' => 8
        ]);

        // 4. Buat Transaksi Dummy (1 Pending, 1 Paid)
        Transaction::create([
            'user_id' => $customer1->id,
            'yoga_class_id' => $class1->id,
            'transaction_code' => 'YWJ-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
            'status' => 'pending'
        ]);

        Transaction::create([
            'user_id' => $customer2->id,
            'yoga_class_id' => $class2->id,
            'transaction_code' => 'YWJ-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
            'status' => 'paid',
            'is_attended' => true
        ]);
    }
}
