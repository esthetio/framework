<?php

declare(strict_types=1);

namespace Esthetio\Dispatcher\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class RequestBody
{
}
