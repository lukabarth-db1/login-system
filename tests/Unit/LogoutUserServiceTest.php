<?php

namespace Tests\Unit;

use App\Http\Services\LogoutUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use PHPUnit\Framework\TestCase;

class LogoutUserServiceTest extends TestCase
{
    public function testItLogsOutUserAndInvalidatesSession(): void
    {
        Auth::shouldReceive('logout')->once();

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('session->invalidate')->once();
        $request->shouldReceive('session->regenerateToken')->once();

        $service = new LogoutUserService();
        $service->execute($request);

        $this->assertTrue(true);
    }
}
