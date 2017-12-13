<?php

namespace Tests\Unit\Billing;

use App\Billing\PlaceToPayPaymentGateway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group  integration
 */
class PlaceToPayPaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

    protected function getPaymentGateway()
    {
        return new PlaceToPayPaymentGateway([
            'login' => config('services.placetopay.login'),
            'tranKey' => config('services.placetopay.tranKey')
        ]);
    }
}
