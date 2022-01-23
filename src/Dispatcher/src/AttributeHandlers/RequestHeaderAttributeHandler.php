<?php

declare(strict_types=1);

namespace Esthete\Dispatcher\AttributeHandlers;

use Esthete\Dispatcher\Attribute\RequestHeader;
use Esthete\Dispatcher\AttributeHandlerInterface;
use Esthete\Dispatcher\Context;
use Esthete\Dispatcher\InvalidAttributeException;
use ReflectionParameter;

class RequestHeaderAttributeHandler implements AttributeHandlerInterface
{
    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed
    {
        if (! $attribute instanceof RequestHeader) {
            throw new InvalidAttributeException(RequestHeader::class);
        }

        return $context->getRequest()->headers->get(
            $attribute->getName() ?? $parameter->getName(),
            $attribute->getDefault()
        );
    }
}
