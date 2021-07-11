<?php


namespace Mleczek\Config\Tests;


use Mleczek\Config\Providers\LocalConfig;
use PHPUnit\Framework\TestCase;

class LocalConfigConstructorTest extends TestCase
{
    public function testCanInitWithInvalidDir()
    {
        $config = new LocalConfig(__DIR__ . '/invalid-dir-name');
        $this->assertNotEmpty($config);
    }

    public function testWorksWithEndingSlash()
    {
        $config = new LocalConfig(__DIR__ . '/resources/');
        $this->assertSame('value', $config->get('sample.key.subkey'));
    }

    public function testWorksWithoutEndingSlash()
    {
        $config = new LocalConfig(__DIR__ . '/resources');
        $this->assertSame('value', $config->get('sample.key.subkey'));
    }
}
