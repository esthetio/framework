<?php

declare(strict_types=1);

namespace Esthetio\Tests\Dispatcher;

use Esthetio\Dispatcher\Context;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ContextTest extends TestCase
{
    public function testGetRequest(): void
    {
        $request = $this->createMock(Request::class);

        $context = new Context($request);

        $this->assertSame($request, $context->getRequest());
    }
}
