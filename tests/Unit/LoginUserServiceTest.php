<?php

namespace Tests\Unit;

use App\Http\Services\LoginUserService;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;

class LoginUserServiceTest extends TestCase
{
    public function testItAuthenticatesUserWithValidCredentials(): void
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'user@example.com', 'password' => 'secret'])
            ->andReturn(true);

        $service = new LoginUserService();

        $this->assertTrue($service->execute([
            'email' => 'user@example.com',
            'password' => 'secret'
        ]));
    }

    public function testItFailsWithInvalidCredentials()
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'user@example.com', 'password' => 'wrong'])
            ->andReturn(false);

        $service = new LoginUserService();

        $this->assertFalse($service->execute([
            'email' => 'user@example.com',
            'password' => 'wrong'
        ]));
    }
}
