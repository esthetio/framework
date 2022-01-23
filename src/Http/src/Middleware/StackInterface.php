<?php

declare(strict_types=1);

namespace Esthete\Http\Middleware;

interface StackInterface
{
    /**
     * @return \Esthete\Http\Middleware\MiddlewareInterface
     */
    public function next(): MiddlewareInterface;
}
