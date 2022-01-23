<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestFile
{
    /** @var string|null */
    private ?string $name;

    /**
     * @param  string|null  $name
     */
    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
