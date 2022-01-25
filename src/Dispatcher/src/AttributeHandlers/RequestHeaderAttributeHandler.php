<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\AttributeHandlers;

use Esthetio\Dispatcher\Attribute\RequestHeader;
use Esthetio\Dispatcher\AttributeHandlerInterface;
use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\Exception\InvalidAttributeException;
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
