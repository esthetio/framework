<?php

declare(strict_types=1);

namespace Esthete\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface TerminableInterface extends MiddlewareInterface
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Request   $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     */
    public function terminate(Request $request, Response $response): void;
}
