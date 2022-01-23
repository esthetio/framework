<?php

declare(strict_types=1);

namespace Esthete\Tests\Http;

use Esthete\Http\AbstractKernel;
use Esthete\Http\Middleware\MiddlewareInterface;
use Esthete\Http\Middleware\TerminableInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractKernelTest extends TestCase
{
    public function testProcess(): void
    {
        $request  = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $middleware = $this->createMock(MiddlewareInterface::class);
        $middleware
            ->expects($this->once())
            ->method('process')
            ->willReturn($response);

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->willReturn([$middleware]);

        $kernel = $this->createKernelStub($container);

        $this->assertSame($response, $kernel->process($request));
    }

    public function testTerminate(): void
    {
        $request  = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $terminable = $this->createMock(TerminableInterface::class);
        $terminable
            ->expects($this->never())
            ->method('process');
        $terminable
            ->expects($this->once())
            ->method('terminate')
            ->with($request, $response);

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->willReturn([$terminable]);

        $kernel = $this->createKernelStub($container);

        $kernel->terminate($request, $response);
    }

    private function createKernelStub(ContainerInterface $container): AbstractKernel
    {
        return new class($container) extends AbstractKernel {
            protected function getPipeline(ContainerInterface $container): array
            {
                return $container->get('');
            }
        };
    }
}
