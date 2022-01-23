<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher;

use Psr\Container\ContainerInterface;

class ControllerFactory implements ControllerFactoryInterface
{
    /** @var \Psr\Container\ContainerInterface */
    private ContainerInterface $container;

    /**
     * @param  \Psr\Container\ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $controller): object
    {
        return $this->container->get($controller);
    }
}
