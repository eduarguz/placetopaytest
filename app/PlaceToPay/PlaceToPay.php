<?php

namespace App\PlaceToPay;

class PlaceToPay
{
    /** @var */
    public $tranKey;

    /** @var  */
    public $login;

    /** @var \App\PlaceToPay\Bank  */
    public $bank;

    /**
     * PlaceToPay constructor.
     *
     * @param $options
     * @throws \Exception
     */
    public function __construct($options)
    {
        $this->login = $options['login'];
        $this->tranKey = $options['tranKey'];

        if (!$this->login && !$this->tranKey) {
            throw new \Exception('Not Login or TranKey provided');
        }

        $this->bank = new Bank($this);
    }
}