<?php

declare(strict_types=1);

namespace Esthetio\Http\Middleware;

interface StackInterface
{
    /**
     * @return \Esthetio\Http\Middleware\MiddlewareInterface
     */
    public function next(): MiddlewareInterface;
}
