<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Order;
use App\PaymentAttempt;
use App\PhotoOnSale;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_see_photos()
    {
        $this->get('/photos')->assertStatus(200);
    }

    /** @test */
    public function guest_can_store_an_order()
    {
        $this->post(route('orders.store'), [
            'email' => 'jhon@example.com',
            'quantity' => 3,
            'method' => 'pse',
        ])->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'quantity' => 3,
            'amount' => PhotoOnSale::price() * 3,
            'email' => 'jhon@example.com'
        ]);

        $this->assertTrue(Order::first()->isMissingPayment());
    }

    /** @test */
    public function storing_a_new_order_requires_an_email()
    {
        $this->post(route('orders.store'), [
            'quantity' => 3,
            'method' => 'pse',
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email'
            ]);
    }

    /** @test */
    public function storing_a_new_order_requires_a_method()
    {
        $this->post(route('orders.store'), [
            'email' => 'jhon@example.com',
            'quantity' => 3,
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'method'
            ]);
    }

    /** @test */
    public function storing_a_new_order_requires_a_valid_method()
    {
        $this->post(route('orders.store'), [
            'method' => 'asdf',
            'email' => 'jhon@example.com',
            'quantity' => 3,
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'method'
            ]);
    }

    /** @test */
    public function storing_a_new_order_requires_a_valid_quantity()
    {
        $this->post(route('orders.store'), [
            'method' => 'pse',
            'email' => 'jhon@example.com',
            'quantity' => 0,
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'quantity'
            ]);
    }
}
