<?php


namespace Mleczek\Config\Tests;


use Mleczek\Config\Providers\LocalConfig;
use PHPUnit\Framework\TestCase;

class LocalConfigTest extends TestCase
{
    private $config;

    public function setUp(): void
    {
        $this->config = new LocalConfig(__DIR__ . '/resources');
    }

    public function testGetValue(): void
    {
        $value = $this->config->get('sample');
        $expected = ['key' => ['subkey' => 'value', 'nullable' => null]];
        $this->assertSame($expected, $value);

        $value = $this->config->get('sample.key');
        $expected = ['subkey' => 'value', 'nullable' => null];
        $this->assertSame($expected, $value);
    }

    public function testHasKey(): void
    {
        $this->assertFalse($this->config->has('missing'));
        $this->assertFalse($this->config->has('missing.key'));
        $this->assertTrue($this->config->has('sample'));
        $this->assertTrue($this->config->has('sample.key'));
    }

    public function testGetDefaultValueIfKeyNotExists(): void
    {
        $value = $this->config->getOrDefault('missing', 'default');
        $this->assertSame('default', $value);

        $value = $this->config->getOrDefault('sample.missing.key');
        $this->assertSame(null, $value);
    }

    public function testGetNullConfigValue(): void
    {
        $value = $this->config->get('sample.key.nullable');
        $this->assertSame(null, $value);
    }

}
