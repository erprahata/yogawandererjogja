<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\YogaClass;

class ApiWorkflowTest extends TestCase
{
    use RefreshDatabase; // Mereset database memory setiap kali test berjalan

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Budi Santoso',
            'phone_number' => '081234567890',
            'email' => 'budi@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['success', 'access_token', 'user']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token']);
    }

    public function test_user_can_checkout_with_qris()
    {
        $user = User::factory()->create();
        $yogaClass = YogaClass::create([
            'name' => 'Vinyasa Flow',
            'price' => 50000,
            'quota' => 10,
            'schedule' => now()->addDays(2),
            'description' => 'Test Class'
        ]);

        $response = $this->actingAs($user)->postJson('/api/checkout', [
            'yoga_class_id' => $yogaClass->id,
            'payment_method' => 'qris'
        ]);

        $response->assertStatus(200)->assertJsonPath('data.payment_method', 'qris');
    }
}