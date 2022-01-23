<?php

declare(strict_types=1);

namespace Esthete\Dispatcher\AttributeHandlers;

use Esthete\Dispatcher\Attribute\RequestBody;
use Esthete\Dispatcher\AttributeHandlerInterface;
use Esthete\Dispatcher\Context;
use Esthete\Dispatcher\InvalidAttributeException;
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
