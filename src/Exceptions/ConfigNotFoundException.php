<?php


namespace Mleczek\Config\Exceptions;


use Exception;
use Throwable;

class ConfigNotFoundException extends Exception
{
    /**
     * Full config key.
     *
     * @var string
     */
    protected string $key;

    /**
     * The part of config key which cannot be found.
     *
     * @var string
     */
    protected string $part;

    /**
     * @param string $key Full config key.
     * @param string $part The part of config key which cannot be found.
     * @param Throwable|null $previous
     */
    public function __construct(string $key, string $part, ?Throwable $previous = null)
    {
        $message = "The '{$key}' config key wasn't found, cannot find the '{$part}' part of a key.";
        parent::__construct($message, 1, $previous);

        $this->key = $key;
        $this->part = $part;
    }
}
