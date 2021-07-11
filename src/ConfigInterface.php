<?php


namespace Mleczek\Config;


use Mleczek\Config\Exceptions\ConfigNotFoundException;

interface ConfigInterface
{
    /**
     * Check whether config key exists.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Get value under given config key.
     *
     * @throws ConfigNotFoundException
     * @return mixed
     * @param string $key
     */
    public function get(string $key);

    /**
     * Get value or return a default value if given key not exists.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOrDefault(string $key, $default = null);
}
