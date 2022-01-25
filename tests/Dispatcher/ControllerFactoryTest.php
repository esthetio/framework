<?php

declare(strict_types=1);

namespace Esthetio\Tests\Dispatcher;

use Esthetio\Dispatcher\ControllerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;

class ControllerFactoryTest extends TestCase
{

    public function testCreate(): void
    {
        $controller = $this->createMock(stdClass::class);

        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with('controller')
            ->willReturn($controller);

        $controllerFactory = new ControllerFactory($container);

        $this->assertSame($controller, $controllerFactory->create('controller'));
    }
}
