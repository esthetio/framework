<?php

declare(strict_types=1);

namespace Esthete\Http\Middleware;

use SplQueue;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class Runner implements MiddlewareInterface, StackInterface
{
    /** @var \SplQueue */
    private SplQueue $queue;

    /**
     * @param  \Esthete\Http\Middleware\MiddlewareInterface[]  $pipeline
     */
    public function __construct(array $pipeline)
    {
        $this->queue = $this->createQueue($pipeline);
    }

    public function process(Request $request, StackInterface $stack): Response
    {
        return new Response('Not Found', Response::HTTP_NOT_FOUND);
    }

    public function next(): MiddlewareInterface
    {
        if ($this->queue->isEmpty()) {
            return $this;
        }

        return $this->queue->dequeue();
    }

    /**
     * @param  \Esthete\Http\Middleware\MiddlewareInterface[]  $pipeline
     *
     * @return \SplQueue
     */
    private function createQueue(array $pipeline): SplQueue
    {
        $queue = new SplQueue();

        foreach ($pipeline as $middleware) {
            $queue->enqueue($middleware);
        }

        return $queue;
    }
}
