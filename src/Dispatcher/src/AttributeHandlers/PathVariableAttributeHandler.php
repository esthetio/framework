<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\AttributeHandlers;

use Esthetio\Dispatcher\Attribute\PathVariable;
use Esthetio\Dispatcher\AttributeHandlerInterface;
use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\InvalidAttributeException;
use ReflectionParameter;

class PathVariableAttributeHandler implements AttributeHandlerInterface
{
    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed
    {
        if (! $attribute instanceof PathVariable) {
            throw new InvalidAttributeException(PathVariable::class);
        }

        return $context->getRequest()->attributes->get(
            $attribute->getName() ?? $parameter->getName(),
            $attribute->getDefault()
        );
    }
}
