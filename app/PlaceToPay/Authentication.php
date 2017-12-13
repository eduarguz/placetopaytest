<?php

namespace App\PlaceToPay;

class Authentication
{
    /** @var  */
    public $login;

    /** @var string  */
    public $tranKey;

    /** @var string  */
    public $seed;

    /** @var array  */
    public $additional;

    /**
     * Authentication constructor.
     *
     * @param $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        self::validateConfig($config);

        $this->seed = $this->seed();
        $this->login = $config['login'];
        $this->tranKey = $this->trankey($config['tranKey']);
        $this->additional = [];
    }

    /**
     * Provides a seed for the sha
     *
     * @return string
     */
    protected function seed()
    {
        return date('c');
    }

    /**
     * Provides the sha1 of the Trankey using a seed
     *
     * @param $tranKey
     * @return string
     */
    protected function tranKey($tranKey) {
        return sha1($this->seed . $tranKey, false);
    }

    /**
     * Validates the configuration is ok
     *
     * @param $config
     * @throws \Exception
     */
    protected static function validateConfig($config)
    {
        if ($config && !is_array($config)) {
            throw new \Exception("You must pass an array as the first argument");
        }
        if (!isset($config['login']) || !isset($config['tranKey'])) {
            throw new \Exception('No login or tranKey provided on authentication');
        }
    }
}