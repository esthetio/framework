<?php

declare(strict_types=1);

namespace Esthete\Dispatcher\AttributeHandlers;

use Esthete\Dispatcher\Attribute\CookieValue;
use Esthete\Dispatcher\AttributeHandlerInterface;
use Esthete\Dispatcher\Context;
use Esthete\Dispatcher\InvalidAttributeException;
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
