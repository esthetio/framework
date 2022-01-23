<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use Symfony\Component\HttpFoundation\Response;

interface ResponseFactoryInterface
{
    /**
     * @param  mixed  $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(mixed $data): Response;
}
