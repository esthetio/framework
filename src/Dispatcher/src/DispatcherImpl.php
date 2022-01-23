<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DispatcherImpl implements Dispatcher
{
    /** @var \Esthete\Dispatcher\ControllerFactoryInterface */
    private ControllerFactoryInterface $controllerFactory;

    /** @var \Esthete\Dispatcher\ResponseFactoryInterface */
    private ResponseFactoryInterface $responseFactory;

    /** @var \Esthete\Dispatcher\InvokerInterface */
    private InvokerInterface $invoker;

    /**
     * @param  \Esthete\Dispatcher\ControllerFactoryInterface  $controllerFactory
     * @param  \Esthete\Dispatcher\ResponseFactoryInterface    $responseFactory
     * @param  \Esthete\Dispatcher\InvokerInterface            $invoker
     */
    public function __construct(
        ControllerFactoryInterface $controllerFactory,
        ResponseFactoryInterface $responseFactory,
        InvokerInterface $invoker
    ) {
        $this->controllerFactory = $controllerFactory;
        $this->responseFactory   = $responseFactory;
        $this->invoker           = $invoker;
    }

    /**
     * @throws \Throwable
     */
    public function dispatch(Request $request, string $controller, string $method): Response
    {
        $invokable = $this->controllerFactory->create($controller);
        $context   = new Context($request);

        try {
            $result = $this->invoker->invokeMethod($context, $invokable, $method);
        } catch (Throwable $e) {
            $result = $this->invoker->invokeException($context, $invokable, $e);
        }

        return $this->responseFactory->create($result);
    }
}
