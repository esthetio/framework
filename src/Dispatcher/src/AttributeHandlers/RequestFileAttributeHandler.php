<?php

declare(strict_types=1);

namespace Esthete\Dispatcher\AttributeHandlers;

use Esthete\Dispatcher\Attribute\RequestFile;
use Esthete\Dispatcher\AttributeHandlerInterface;
use Esthete\Dispatcher\Context;
use Esthete\Dispatcher\InvalidAttributeException;
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
