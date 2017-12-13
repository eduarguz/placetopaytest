<?php

namespace App\Billing;

interface PaymentGateway
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getBankList();

    /**
     * @return string|int
     */
    public function getValidTestBankCode();

    /**
     * @param $data
     * @param $params
     * @return object
     */
    public function createTransaction($data, $params);

    /**
     * @param $id
     * @return object
     */
    public function getTransaction($id);
}