<?php

namespace App\Billing;

class FakePaymentGateway implements PaymentGateway
{
    /**
     * Returns a Fake list of banks.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getBankList()
    {
        return collect([
            (object)[
                "bankCode" => "0",
                "bankName" => "A continuación seleccione su banco"
            ],
            (object)[
                "bankCode" => "1552",
                "bankName" => "BAN.CO"
            ],
            (object)[
                "bankCode" => "1040",
                "bankName" => "BANCO AGRARIO"
            ],
            (object)[
                "bankCode" => "1081",
                "bankName" => "BANCO AGRARIO DESARROLLO"
            ]
        ]);
    }

    /**
     * Creates a fake transaction and resturns it
     *
     * @param $data
     * @param array $params
     * @return \stdClass
     */
    public function createTransaction($data, $params = [])
    {
        $transactionResponse = new \stdClass();
        $transactionResponse->returnCode = "SUCCESS";
        $transactionResponse->bankURL = "https://registro.desarrollo.pse.com.co/PSEUserRegister/StartTransaction.htm?enc=tnPcJHMKlSnmRpHM8fAbu4mLVWByubIwxm0lMNrymBnUiflneeXj%2fKl0iAaQJhQ4";
        $transactionResponse->trazabilityCode = "1369670";
        $transactionResponse->transactionCycle = 1;
        $transactionResponse->transactionID = 1453073068;
        $transactionResponse->sessionID = "d05a5f5650b46354b05ff2abffbf2d44";
        $transactionResponse->bankCurrency = "COP";
        $transactionResponse->bankFactor = 1.0;
        $transactionResponse->responseCode = "?-";
        $transactionResponse->responseReasonText = "Transacción pendiente. Por favor verificar si el débito fue realizado en el Banco.";

        return $transactionResponse;
    }

    /**
     * Gets a bank code from the fake bank list.
     *
     * @return mixed
     */
    public function getValidTestBankCode()
    {
        return $this->getBankList()[1]->bankCode;
    }

    /**
     * Gets a Fake transaction
     *
     * @param $id
     * @return \stdClass
     */
    public function getTransaction($id)
    {
        $transactionResponse = new \stdClass();
        $transactionResponse->transactionID = 1453098999;
        $transactionResponse->sessionID = "bb9aee0442fb26acdbb03971a1e14607";
        $transactionResponse->reference = "121r4qfaeffaefa";
        $transactionResponse->requestDate = "2017-12-11T21:26:27-05:00";
        $transactionResponse->bankProcessDate = "2017-12-11T21:26:28-05:00";
        $transactionResponse->onTest = true;
        $transactionResponse->returnCode = "SUCCESS";
        $transactionResponse->trazabilityCode = "1369848";
        $transactionResponse->transactionCycle = - 1;
        $transactionResponse->transactionState = "PENDING";
        $transactionResponse->responseCode = 3;
        $transactionResponse->responseReasonCode = "?-";
        $transactionResponse->responseReasonText = "Transacción pendiente. Por favor verificar si el débito fue realizado en el Banco.";
        return $transactionResponse;
    }
}