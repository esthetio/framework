<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use InvalidArgumentException;
use ReflectionNamedType;
use ReflectionParameter;
use Symfony\Component\HttpFoundation\Request;

class ArgumentResolver implements ArgumentResolverInterface
{
    /** @var \Esthete\Dispatcher\AttributeHandlerInterface[] */
    private array $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * @param  string                                         $attribute
     * @param  \Esthete\Dispatcher\AttributeHandlerInterface  $handler
     */
    public function addHandler(string $attribute, AttributeHandlerInterface $handler): void
    {
        $this->handlers[$attribute] = $handler;
    }

    /**
     * @param  string  $attribute
     *
     * @return bool
     */
    private function hasHandler(string $attribute): bool
    {
        return isset($this->handlers[$attribute]);
    }

    public function resolve(Context $context, ReflectionParameter $parameter): mixed
    {
        $type = $parameter->getType();

        if ($type instanceof ReflectionNamedType && $type->getName() === Request::class) {
            return $context->getRequest();
        }

        foreach ($parameter->getAttributes() as $attribute) {
            $name = $attribute->getName();

            if ($this->hasHandler($name)) {
                return $this->handlers[$name]->handle($context, $parameter, $attribute->newInstance());
            }
        }

        throw new InvalidArgumentException(sprintf('Cannot resolve "%s" parameter', $parameter->getName()));
    }
}
