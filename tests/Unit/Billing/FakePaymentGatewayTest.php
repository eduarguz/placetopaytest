<?php

namespace Tests\Unit\Billing;

use App\Billing\FakePaymentGateway;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FakePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractTest;

    protected function getPaymentGateway()
    {
        return new FakePaymentGateway;
    }
}
