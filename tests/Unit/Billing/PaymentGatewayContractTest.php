<?php

namespace Tests\Unit\Billing;

use Illuminate\Support\Collection;

trait PaymentGatewayContractTest
{

    abstract protected function getPaymentGateway();

//    /** @test */
//    public function can_fetch_bank_list_as_collection()
//    {
//        $paymentGateway = $this->getPaymentGateway();
//
//        $banks = $paymentGateway->getBankList();
//
//        $this->assertInstanceOf(Collection::class, $banks);
//        $banks->each(function ($item) {
//            $this->assertArrayHasKey('bankCode', $item);
//            $this->assertArrayHasKey('bankName', $item);
//        });
//    }

    /** @test */
//    public function can_create_transaction()
//    {
//        $paymentGateway = $this->getPaymentGateway();
//        $transaction = new \StdClass ();
//        $transaction->bankCode = $paymentGateway->getValidTestBankCode();
//        $transaction->bankInterface = 0;
//        $transaction->returnURL = 'http://okarook.com';
//        $transaction->reference = '121r4qfaeffaefa';
//        $transaction->description = 'Lorem Ipsum description';
//        $transaction->language = 'ES';
//        $transaction->currency = 'COP';
//        $transaction->totalAmount = 1500000;
//        $transaction->payer = $this->getPersonOne();
//        $transaction->ipAddress = '10.10.1.12';
//        $transaction->userAgent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0)Gecko/20100101 Firefox/50.0';
//        $transaction->additionalData = [];
//
//        $response = $paymentGateway->createTransaction($transaction);
//        $this->assertTrue(gettype($response) == 'object');
//    }

    /** @test */
    public function getTransaction () {
        $paymentGateway = $this->getPaymentGateway();
        $transaction = new \StdClass ();
        $transaction->bankCode = $paymentGateway->getValidTestBankCode();
        $transaction->bankInterface = 0;
        $transaction->returnURL = 'http://okarook.com';
        $transaction->reference = '121r4qfaeffaefa';
        $transaction->description = 'Lorem Ipsum description';
        $transaction->language = 'ES';
        $transaction->currency = 'COP';
        $transaction->totalAmount = 1500000;
        $transaction->payer = $this->getPersonOne();
        $transaction->ipAddress = '10.10.1.12';
        $transaction->userAgent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0)Gecko/20100101 Firefox/50.0';
        $transaction->additionalData = [];

        $transaction = $paymentGateway->createTransaction($transaction);

        $transactionResponse = $paymentGateway->getTransaction($transaction->transactionID);
        $this->assertTrue(gettype($transactionResponse) == 'object');
    }

    private function getPersonOne()
    {
        $person = new \stdClass();
        $person->document = '1021123456';
        $person->documentType = 'CC';
        $person->firstName = 'Jhon';
        $person->lastName = 'Doe';
        $person->emailAddress = 'jhon@example.com';
        return $person;
    }
}