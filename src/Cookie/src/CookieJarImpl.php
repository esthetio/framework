<?php

declare(strict_types=1);

namespace Esthetio\Cookie;

use Symfony\Component\HttpFoundation\Cookie;

class CookieJarImpl implements CookieJar
{
    /** @var \Symfony\Component\HttpFoundation\Cookie[] */
    private array $cookies;

    public function __construct()
    {
        $this->cookies = [];
    }

    public function add(Cookie $cookie): void
    {
        $this->cookies[$cookie->getName()] = $cookie;
    }

    public function expire(string $name, ?string $path = null, ?string $domain = null): void
    {
        $this->cookies[$name] = new Cookie($name, null, $this->getSeconds(-2628000), $path, $domain);
    }

    public function flush(): array
    {
        $cookies       = array_values($this->cookies);
        $this->cookies = [];

        return $cookies;
    }

    /**
     * @param  int  $minutes
     *
     * @return int
     */
    private function getSeconds(int $minutes): int
    {
        return $minutes * 60;
    }
}
