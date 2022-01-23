<?php

declare(strict_types=1);

namespace Esthetio\Http;

use Esthetio\Http\Middleware\Runner;
use Esthetio\Http\Middleware\TerminableInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractKernel implements KernelInterface
{
    /** @var \Esthetio\Http\Middleware\MiddlewareInterface[] */
    private array $pipeline;

    /**
     * @return \Esthetio\Http\Middleware\MiddlewareInterface[]
     */
    abstract protected function getPipeline(ContainerInterface $container): array;

    /**
     * @param  \Psr\Container\ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->pipeline = $this->getPipeline($container);
    }

    public function process(Request $request): Response
    {
        $runner = new Runner($this->pipeline);

        return $runner->next()->process($request, $runner);
    }

    public function terminate(Request $request, Response $response): void
    {
        foreach ($this->pipeline as $middleware) {
            if ($middleware instanceof TerminableInterface) {
                $middleware->terminate($request, $response);
            }
        }
    }
}
