<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher;

use InvalidArgumentException;

class InvalidAttributeException extends InvalidArgumentException
{
    public function __construct(string $attribute)
    {
        parent::__construct(sprintf('Attribute "%s" is not supported by this handler', $attribute));
    }
}
