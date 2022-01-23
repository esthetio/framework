<?php

declare(strict_types=1);

namespace Esthete\Dispatcher;

use InvalidArgumentException;
use ReflectionMethod;

/**
 * @internal
 */
final class Reflector
{
    /** @var object */
    private object $invokable;

    /** @var \ReflectionMethod */
    private ReflectionMethod $reflectionMethod;

    /**
     * @param  object  $invokable
     * @param  string  $method
     */
    public function __construct(object $invokable, string $method)
    {
        if (! method_exists($invokable, $method)) {
            throw new InvalidArgumentException(sprintf('Invokable has no "%s" method', $method));
        }

        $this->invokable        = $invokable;
        $this->reflectionMethod = new ReflectionMethod($invokable, $method);
    }

    /**
     * @return \ReflectionParameter[]
     */
    public function getParameters(): array
    {
        return $this->reflectionMethod->getParameters();
    }

    /**
     * @throws \ReflectionException
     */
    public function invoke(array $arguments): mixed
    {
        return $this->reflectionMethod->invokeArgs($this->invokable, $arguments);
    }
}
