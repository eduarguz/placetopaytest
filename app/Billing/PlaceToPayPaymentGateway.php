<?php

namespace App\Billing;

use App\PlaceToPay\Bank as PlaceToPayBank;
use App\PlaceToPay\PlaceToPay;
use Illuminate\Support\Facades\Cache;

class PlaceToPayPaymentGateway implements PaymentGateway
{
    /**
     * @var \App\PlaceToPay\PlaceToPay
     */
    protected $placeToPay;

    /**
     * PlaceToPayPaymentGateway constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->placeToPay = new PlaceToPay([
            'login' => $config['login'],
            'tranKey' => $config['tranKey']
        ]);
    }

    /**
     * Returns a collection with the list of banks
     *
     * @return \Illuminate\Support\Collection
     */
    public function getBankList()
    {
        try {
            $banks = Cache::remember('placetopay.banks', 24 * 60, function () {
                return collect($this->placeToPay->bank->getList());
            });
        } catch (\Exception $e) {
            $banks = collect([
                (object) ["bankCode" => "0", "bankName" => "No se pudo cargar una lista, intenta de nuevo."]
            ]);
        }

        return $banks;
    }

    /**
     * Creates a new Transaction using Placetopay PSE
     *
     * @param $data
     * @param array $params
     * @return object
     * @throws \Exception
     */
    public function createTransaction($data, $params = [])
    {
        return $this->placeToPay->bank->create($data);
    }

    /**
     * Gets a transaction from the Placetopay WS
     *
     * @param $id
     * @return object
     * @throws \Exception
     */
    public function getTransaction($id)
    {
        return $this->placeToPay->bank->get($id);
    }

    /**
     * Gets a valid test code for the list of banks.
     *
     * @return string
     */
    public function getValidTestBankCode()
    {
        return '1022';
    }
}