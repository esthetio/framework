<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use Throwable;

interface InvokerInterface
{
    /**
     * @param  \Esthete\Dispatcher\Context  $context
     * @param  object                       $invokable
     * @param  string                       $method
     *
     * @return mixed
     */
    public function invokeMethod(Context $context, object $invokable, string $method): mixed;

    /**
     * @param  \Esthete\Dispatcher\Context  $context
     * @param  object                       $invokable
     * @param  \Throwable                   $e
     *
     * @return mixed
     * @throws \Throwable
     */
    public function invokeException(Context $context, object $invokable, Throwable $e): mixed;
}
