<?php

namespace Tests\Feature;

use App\Http\Services\RegisterUserService;
use App\Http\Services\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testUserIsSavedToDatabase(): void
    {
        $tokenService = $this->createMock(TokenService::class);

        $service = new RegisterUserService($tokenService);

        $service->create([
            'name' => 'PHPUnit',
            'email' => 'phpunit@example.com',
            'password' => 'phpunit123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'phpunit@example.com',
        ]);
    }
}
