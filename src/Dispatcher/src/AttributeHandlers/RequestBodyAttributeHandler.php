<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\AttributeHandlers;

use Esthetio\Dispatcher\Attribute\RequestBody;
use Esthetio\Dispatcher\AttributeHandlerInterface;
use Esthetio\Dispatcher\Context;
use Esthetio\Dispatcher\Exception\InvalidAttributeException;
use InvalidArgumentException;
use ReflectionNamedType;
use ReflectionParameter;
use Symfony\Component\Serializer\SerializerInterface;

class RequestBodyAttributeHandler implements AttributeHandlerInterface
{
    /** @var \Symfony\Component\Serializer\SerializerInterface */
    private SerializerInterface $serializer;

    /**
     * @param  \Symfony\Component\Serializer\SerializerInterface  $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function handle(Context $context, ReflectionParameter $parameter, object $attribute): mixed
    {
        if (! $attribute instanceof RequestBody) {
            throw new InvalidAttributeException(RequestBody::class);
        }

        $type = $parameter->getType();

        if (! $type instanceof ReflectionNamedType) {
            throw new InvalidArgumentException('Parameter should have a named type');
        }

        if ($contentType = $context->getRequest()->getContentType()) {
            return $this->serializer->deserialize(
                $context->getRequest()->getContent(),
                $type->getName(),
                $contentType
            );
        }

        throw new InvalidArgumentException('Content-Type should be either json or xml');
    }
}
