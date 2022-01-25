<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher;

use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 */
final class Context
{
    /** @var \Symfony\Component\HttpFoundation\Request */
    private Request $request;

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
