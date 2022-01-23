<?php

declare(strict_types=1);

namespace Esthetio\Config;

interface Config
{
    /**
     * @param  string      $path
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function get(string $path, mixed $default = null): mixed;
}
