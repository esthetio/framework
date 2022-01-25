<?php

declare(strict_types=1);

namespace Esthetio\Tests\Dispatcher;

use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\ControllerFactoryInterface;
use Esthetio\Dispatcher\DispatcherImpl;
use Esthetio\Dispatcher\InvokerInterface;
use Esthetio\Dispatcher\ResponseFactoryInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DispatcherImplTest extends TestCase
{
    private Request $request;
    private Response $response;
    private stdClass $controller;
    private ControllerFactoryInterface $controllerFactory;
    private ResponseFactoryInterface $responseFactory;

    protected function setUp(): void
    {
        $this->request           = $this->createMock(Request::class);
        $this->response          = $this->createMock(Response::class);
        $this->controller        = $this->createMock(stdClass::class);
        $this->controllerFactory = $this->createMock(ControllerFactoryInterface::class);
        $this->responseFactory   = $this->createMock(ResponseFactoryInterface::class);

        $this->controllerFactory
            ->expects($this->once())
            ->method('create')
            ->with('TestController')
            ->willReturn($this->controller);

        $this->responseFactory
            ->expects($this->once())
            ->method('create')
            ->with('controller result')
            ->willReturn($this->response);
    }

    public function testDispatch(): void
    {
        $invoker = $this->createMock(InvokerInterface::class);
        $invoker
            ->expects($this->once())
            ->method('invokeMethod')
            ->with(new Context($this->request), $this->controller, '__invoke')
            ->willReturn('controller result');

        $dispatcher = new DispatcherImpl($this->controllerFactory, $this->responseFactory, $invoker);

        $this->assertSame(
            $this->response,
            $dispatcher->dispatch($this->request, 'TestController', '__invoke')
        );
    }

    public function testDispatchWithException(): void
    {
        $exception = $this->createMock(Exception::class);

        $invoker = $this->createMock(InvokerInterface::class);
        $invoker
            ->expects($this->once())
            ->method('invokeMethod')
            ->with(new Context($this->request), $this->controller, '__invoke')
            ->willThrowException($exception);
        $invoker
            ->expects($this->once())
            ->method('invokeException')
            ->with(new Context($this->request), $this->controller, $exception)
            ->willReturn('controller result');

        $dispatcher = new DispatcherImpl($this->controllerFactory, $this->responseFactory, $invoker);

        $this->assertSame(
            $this->response,
            $dispatcher->dispatch($this->request, 'TestController', '__invoke')
        );
    }
}
