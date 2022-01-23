<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

interface ControllerFactoryInterface
{
    /**
     * @param  string  $controller
     *
     * @return object
     */
    public function create(string $controller): object;
}
