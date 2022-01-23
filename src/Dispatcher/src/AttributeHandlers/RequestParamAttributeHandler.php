<?php

declare(strict_types=1);

namespace Esthete\Dispatcher\AttributeHandlers;

use Esthete\Dispatcher\Attribute\RequestParam;
use Esthete\Dispatcher\AttributeHandlerInterface;
use Esthete\Dispatcher\Context;
use Esthete\Dispatcher\InvalidAttributeException;
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
