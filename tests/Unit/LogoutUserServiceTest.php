<?php

namespace Tests\Unit;

use App\Http\Services\LogoutUserService;
use Illuminate\Http\Request;
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
        $session = Mockery::mock();
        $session->shouldReceive('forget')->with('user_id')->once();
        $session->shouldReceive('invalidate')->once();
        $session->shouldReceive('regenerateToken')->once();

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('session')->andReturn($session);

        $service = new LogoutUserService();
        $service->execute($request);

        $this->assertTrue(true);
    }
}
