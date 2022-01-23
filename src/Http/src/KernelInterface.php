<?php

declare(strict_types=1);

namespace Esthete\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface KernelInterface
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function process(Request $request): Response;

    /**
     * @param  \Symfony\Component\HttpFoundation\Request   $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     */
    public function terminate(Request $request, Response $response): void;
}
