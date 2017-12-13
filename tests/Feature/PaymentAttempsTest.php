<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Order;
use App\PaymentAttempt;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentAttempsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function guest_can_start_paying_for_an_order()
    {
        $this->withoutExceptionHandling();
        $order = factory(Order::class)->create();

        $response = $this->get(route('orders.payments.pse.create', $order))->assertStatus(200);

        $viewOrder = $response->original->getData()['order'];
        $this->assertTrue($viewOrder->is($order));
        $response->assertViewHas('banks');
    }

    /** @test */
    public function guest_can_pay_an_order()
    {
        $order = factory(Order::class)->create();
        $this->assertNull(PaymentAttempt::latest()->first());

        $response = $this->post(route('orders.payments.pse.store', $order), [
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'document_type' => 'CC',
            'document' => '1234567890',
            'person_type' => '1',
            'bank_code' => $this->paymentGateway->getValidTestBankCode()
        ]);
        $this->assertNotNull(PaymentAttempt::latest()->first());
        $response->assertStatus(302);
    }

    /** @test */
    public function some_fields_are_required_to_pay_an_order () {
        $order = factory(Order::class)->create();

        $response = $this->post(route('orders.payments.pse.store', $order), [

        ])->assertStatus(302);

        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'document_type',
            'document',
            'person_type',
            'bank_code',
        ]);
    }
}
