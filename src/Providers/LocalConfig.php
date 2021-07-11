<?php


namespace Mleczek\Config\Providers;


use Mleczek\Config\ConfigInterface;
use Mleczek\Config\Exceptions\ConfigNotFoundException;

/**
 * Load configuration from local filesystem.
 *
 * Each key is separated using delimiter character, where:
 * - first part determine the filename and
 * - second and subsequent parts are array keys.
 *
 * For example a key 'database.connection.user' will evaluate to:
 * require("$dir/database.php")['connection']['user']
 *
 * Each configuration file should be a flat php file
 * that returns an associative array.
 */
class LocalConfig implements ConfigInterface
{
    /**
     * Character which will be used to explode key for parts.
     */
    private const DELIMITER = '.';

    /**
     * Location of directory with configuration files.
     *
     * @var string
     */
    private string $dir;

    /**
     * @param string $dir
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    /**
     * Check whether config key exists.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        try {
            $this->get($key);
            return true;
        } catch (ConfigNotFoundException $e) {
            return false;
        }
    }

    /**
     * Get value under given config key.
     *
     * @throws ConfigNotFoundException
     * @return mixed
     * @param string $key
     */
    public function get(string $key)
    {
        $parts = explode(self::DELIMITER, $key);
        $filename = array_shift($parts);

        $path = "{$this->dir}/{$filename}.php";
        if (!is_file($path)) {
            // The config file wasn't found.
            throw new ConfigNotFoundException($key, $filename);
        }

        $value = require $path;
        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                // The part of the config key wasn't found.
                throw new ConfigNotFoundException($key, $part);
            }

            $value = $value[$part];
        }

        return $value;
    }

    /**
     * Get value or return a default value if given key not exists.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOrDefault(string $key, $default = null)
    {
        try {
            return $this->get($key);
        } catch (ConfigNotFoundException $e) {
            return $default;
        }
    }
}
