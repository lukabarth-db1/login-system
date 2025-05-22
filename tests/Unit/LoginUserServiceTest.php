<?php

namespace Tests\Unit;

use App\Http\Services\LoginUserService;
use App\Http\Services\TokenService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
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

        $tokenService = $this->createMock(TokenService::class);

        $tokenService->method('encodedTokenGenerate')
            ->with('1')
            ->willReturn('fake_token');

        $service = new LoginUserService($tokenService);

        $result = $service->execute([
            'email' => 'user@example.com',
            'password' => 'secret',
        ]);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
        $this->assertEquals('fake_token', $result);
    }

    public function testItFailsWithInvalidCredentials(): void
    {
        User::create([
            'name' => 'User Test',
            'email' => 'user@example.com',
            'password' => Hash::make('secret'),
        ]);

        $tokenService = $this->createMock(TokenService::class);

        $service = new LoginUserService($tokenService);

        $result = $service->execute([
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertNull($result);
    }
}
