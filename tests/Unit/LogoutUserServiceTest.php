<?php

namespace Tests\Unit;

use App\Http\Services\LogoutUserService;
use App\Http\Services\TokenService;
use Mockery;
use PHPUnit\Framework\TestCase;

class LogoutUserServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testItLogsOutUserAndInvalidatesSession(): void
    {
        session_start();

        $_SESSION['user_id'] = 1;
        $_SESSION['token'] = base64_encode('1');

        $this->assertArrayHasKey('user_id', $_SESSION);
        $this->assertArrayHasKey('token', $_SESSION);

        $tokenService = $this->createMock(TokenService::class);

        $service = new LogoutUserService($tokenService);
        $service->execute();

        $this->assertArrayNotHasKey('user_id', $_SESSION);
        $this->assertArrayNotHasKey('token', $_SESSION);
    }
}
