<?php

declare(strict_types=1);

namespace Esthetio\Cookie;

use Symfony\Component\HttpFoundation\Cookie;

interface CookieJar
{
    /**
     * @param  \Symfony\Component\HttpFoundation\Cookie  $cookie
     */
    public function add(Cookie $cookie): void;

    /**
     * @param  string       $name
     * @param  string|null  $path
     * @param  string|null  $domain
     */
    public function expire(string $name, ?string $path = null, ?string $domain = null): void;

    /**
     * @return \Symfony\Component\HttpFoundation\Cookie[]
     */
    public function flush(): array;
}
