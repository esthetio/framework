<?php

declare(strict_types=1);

namespace Esthetio\Tests\Config;

use Esthetio\Config\ConfigImpl;
use PHPUnit\Framework\TestCase;

class ConfigImplTest extends TestCase
{
    public function testExistentPath(): void
    {
        $config = new ConfigImpl(['foo' => ['bar' => 'value']]);

        $this->assertSame('value', $config->get('foo.bar'));
    }

    public function testNonExistentPath(): void
    {
        $config = new ConfigImpl([]);

        $this->assertNull($config->get('foo'));
    }

    public function testDefaultValue(): void
    {
        $config = new ConfigImpl([]);

        $this->assertSame('default', $config->get('foo', 'default'));
    }
}
