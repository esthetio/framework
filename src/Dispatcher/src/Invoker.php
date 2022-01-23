<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher;

use Esthetio\Dispatcher\Attribute\ExceptionHandler;
use ReflectionClass;
use ReflectionMethod;
use Throwable;

class Invoker implements InvokerInterface
{
    /** @var \Esthetio\Dispatcher\ArgumentResolverInterface */
    private ArgumentResolverInterface $argumentResolver;

    /**
     * @param  \Esthetio\Dispatcher\ArgumentResolverInterface  $argumentResolver
     */
    public function __construct(ArgumentResolverInterface $argumentResolver)
    {
        $this->argumentResolver = $argumentResolver;
    }

    /**
     * @throws \ReflectionException
     */
    public function invokeMethod(Context $context, object $invokable, string $method): mixed
    {
        $reflector = $this->getReflector($invokable, $method);
        $arguments = [];

        foreach ($reflector->getParameters() as $parameter) {
            $arguments[] = $this->argumentResolver->resolve($context, $parameter);
        }

        return $reflector->invoke($arguments);
    }

    public function invokeException(Context $context, object $invokable, Throwable $e): mixed
    {
        $reflectionClass = new ReflectionClass($invokable);
        $exceptionClass  = get_class($e);

        foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            $reflectionAttributes = $reflectionMethod->getAttributes(ExceptionHandler::class);

            if (! empty($reflectionAttributes)) {
                $attribute = $reflectionAttributes[0]->newInstance();

                if (! $attribute instanceof ExceptionHandler) {
                    throw new InvalidAttributeException(ExceptionHandler::class);
                }

                foreach ($attribute->getExceptions() as $exception) {
                    /** @phpstan-ignore-next-line */
                    if (is_subclass_of($e, $exception) || $exceptionClass === $exception) {
                        $reflector = $this->getReflector($invokable, $reflectionMethod->getName());
                        $arguments = [$e];

                        foreach ($reflector->getParameters() as $parameter) {
                            if ($parameter->getPosition() === 0) {
                                continue;
                            }

                            $arguments[] = $this->argumentResolver->resolve($context, $parameter);
                        }

                        return $reflector->invoke($arguments);
                    }
                }
            }
        }

        throw $e;
    }

    /**
     * @param  object  $invokable
     * @param  string  $method
     *
     * @return \Esthetio\Dispatcher\Reflector
     * @throws \ReflectionException
     */
    private function getReflector(object $invokable, string $method): Reflector
    {
        return new Reflector($invokable, $method);
    }
}
