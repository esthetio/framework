<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\AttributeHandlers;

use Esthetio\Dispatcher\Attribute\RequestParam;
use Esthetio\Dispatcher\AttributeHandlerInterface;
use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\Exception\InvalidAttributeException;
use ReflectionParameter;

class RequestParamAttributeHandler implements AttributeHandlerInterface
{
    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed
    {
        if (! $attribute instanceof RequestParam) {
            throw new InvalidAttributeException(RequestParam::class);
        }

        return $context->getRequest()->query->get(
            $attribute->getName() ?? $parameter->getName(),
            $attribute->getDefault()
        );
    }
}
