<?php

namespace Tests\Unit;

use App\Http\Services\LoginUserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginUserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testItAuthenticatesUserWithValidCredentials(): void
    {
        User::create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => Hash::make('secret'),
        ]);

        $service = new LoginUserService();

        $result = $service->execute([
            'email' => 'user@example.com',
            'password' => 'secret',
        ]);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
        $this->assertTrue(base64_decode($result, true) !== false);
    }

    public function testItFailsWithInvalidCredentials(): void
    {
        User::create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => Hash::make('secret'),
        ]);

        $service = new LoginUserService();

        $result = $service->execute([
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertNull($result);
    }
}
