<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use ReflectionParameter;

interface ArgumentResolverInterface
{
    /**
     * @param  \Esthete\Dispatcher\Context  $context
     * @param  \ReflectionParameter         $parameter
     *
     * @return mixed
     */
    public function resolve(Context $context, ReflectionParameter $parameter): mixed;
}
