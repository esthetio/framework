<?php

declare(strict_types=1);

namespace Esthetio\Config;

class ConfigImpl implements Config
{
    /** @var array */
    private array $config;

    /**
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $path, mixed $default = null): mixed
    {
        $snapshot  = $this->config;
        $fragments = explode('.', $path);

        while ($fragment = array_shift($fragments)) {
            if (! isset($snapshot[$fragment])) {
                return $default;
            }

            $snapshot = $snapshot[$fragment];
        }

        return $snapshot;
    }
}
