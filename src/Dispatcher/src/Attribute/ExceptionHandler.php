<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class ExceptionHandler
{
    /** @var string[] */
    private array $exceptions;

    /**
     * @param  string|string[]  $exceptions
     */
    public function __construct(string|array $exceptions)
    {
        $this->exceptions = is_string($exceptions) ? [$exceptions] : $exceptions;
    }

    /**
     * @return string[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }
}
