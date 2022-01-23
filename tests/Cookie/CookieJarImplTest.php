<?php

declare(strict_types=1);

namespace Esthetio\Tests\Cookie;

use Esthetio\Cookie\CookieJarImpl;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Cookie;

class CookieJarImplTest extends TestCase
{
    public function testFlushedCookies(): void
    {
        $jar = new CookieJarImpl();

        $firstCookie = Cookie::create('first');
        $secondCookie = Cookie::create('second');

        $jar->add($firstCookie);
        $jar->add($secondCookie);

        $flushed = $jar->flush();

        $this->assertCount(2, $flushed);
        $this->assertSame($firstCookie, $flushed[0]);
        $this->assertSame($secondCookie, $flushed[1]);

        $this->assertEmpty($jar->flush());
    }

    public function testJarEmptyByDefault(): void
    {
        $this->assertEmpty((new CookieJarImpl())->flush());
    }

    public function testExpire(): void
    {
        $jar = new CookieJarImpl();

        $jar->expire('expired', '/path', 'www.domain.com');

        $cookie = $jar->flush()[0];

        $this->assertSame('expired', $cookie->getName());
        $this->assertSame('/path', $cookie->getPath());
        $this->assertSame('www.domain.com', $cookie->getDomain());
        $this->assertSame(0, $cookie->getExpiresTime());
    }
}
