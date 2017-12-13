<?php

namespace App\PlaceToPay;

use App\PlaceToPay\Client;

class Bank extends Resource
{

    /**
     * Get the list of banks.
     *
     * @return object
     * @throws \Exception
     */
    public function getList()
    {
        try {
            $response = $this->action('getBankList', [
                'auth' => $this->auth()
            ]);

            return $response->getBankListResult->item;
        } catch (\RuntimeException $e) {
            throw new \Exception("Failed to ge the banks");
        }
    }

    /**
     * Create a transaction.
     *
     * @param $data
     * @return object
     * @throws \Exception
     */
    public function create($data)
    {
        try {
            $response = $this->action('createTransaction', [
                'auth' => $this->auth(),
                'transaction' => $data
            ]);

            return $response->createTransactionResult;
        } catch (\RuntimeException $e) {
            throw new \Exception("Failed to create the transaction");
        }
    }

    /**
     * Get a transaction using the id.
     *
     * @param $id
     * @return object
     * @throws \Exception
     */
    public function get($id)
    {
        try {
            $response = $this->action('getTransactionInformation', [
                'auth' => $this->auth(),
                'transactionID' => $id
            ]);

            return $response->getTransactionInformationResult;
        } catch (\RuntimeException $e) {
            throw new \Exception("Failed to get the transaction");
        }
    }
}