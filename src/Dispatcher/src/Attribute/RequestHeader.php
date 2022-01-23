<?php

declare(strict_types=1);

namespace Esthete\Dispatcher\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestHeader
{
    /** @var string|null */
    private ?string $name;

    /** @var mixed */
    private mixed $default;

    /**
     * @param  string|null  $name
     * @param  mixed        $default
     */
    public function __construct(?string $name = null, mixed $default = null)
    {
        $this->name    = $name;
        $this->default = $default;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }
}
