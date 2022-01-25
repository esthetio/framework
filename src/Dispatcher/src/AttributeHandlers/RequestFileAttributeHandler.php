<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\AttributeHandlers;

use Esthetio\Dispatcher\Attribute\RequestFile;
use Esthetio\Dispatcher\AttributeHandlerInterface;
use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\Exception\InvalidAttributeException;
use ReflectionParameter;

class RequestFileAttributeHandler implements AttributeHandlerInterface
{
    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed
    {
        if (! $attribute instanceof RequestFile) {
            throw new InvalidAttributeException(RequestFile::class);
        }

        return $context->getRequest()->files->get($attribute->getName() ?? $parameter->getName());
    }
}
