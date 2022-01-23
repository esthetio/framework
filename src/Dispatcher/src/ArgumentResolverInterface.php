<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher;

use ReflectionParameter;

interface ArgumentResolverInterface
{
    /**
     * @param  \Esthetio\Dispatcher\Context  $context
     * @param  \ReflectionParameter         $parameter
     *
     * @return mixed
     */
    public function resolve(Context $context, ReflectionParameter $parameter): mixed;
}
