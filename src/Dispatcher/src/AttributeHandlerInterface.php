<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher;

use ReflectionParameter;

interface AttributeHandlerInterface
{
    /**
     * @param  \Esthetio\Dispatcher\Context  $context
     * @param  \ReflectionParameter         $parameter
     * @param  object                       $attribute
     *
     * @return mixed
     */
    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed;
}
