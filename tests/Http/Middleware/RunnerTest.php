<?php

declare(strict_types=1);

namespace Esthetio\Tests\Http\Middleware;

use Esthetio\Http\Middleware\MiddlewareInterface;
use Esthetio\Http\Middleware\Runner;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RunnerTest extends TestCase
{
    public function testWithMiddleware(): void
    {
        $middleware = $this->createMock(MiddlewareInterface::class);

        $runner = new Runner([$middleware]);

        $this->assertSame($middleware, $runner->next());
    }

    public function testEmptyStack(): void
    {
        $request = $this->createMock(Request::class);
        $runner  = new Runner([]);

        $this->assertSame('Not Found', $runner->next()->process($request, $runner)->getContent());
    }
}
