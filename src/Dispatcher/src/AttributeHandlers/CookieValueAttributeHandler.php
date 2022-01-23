<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\AttributeHandlers;

use Esthetio\Dispatcher\Attribute\CookieValue;
use Esthetio\Dispatcher\AttributeHandlerInterface;
use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\InvalidAttributeException;
use ReflectionParameter;

class CookieValueAttributeHandler implements AttributeHandlerInterface
{
    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed
    {
        if (! $attribute instanceof CookieValue) {
            throw new InvalidAttributeException(CookieValue::class);
        }

        return $context->getRequest()->cookies->get(
            $attribute->getName() ?? $parameter->getName(),
            $attribute->getDefault()
        );
    }
}
