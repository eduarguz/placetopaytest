<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Billing\PaymentGateway;
use App\PhotoOnSale;
use App\Order;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Return a view with all resources.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('orders.index')->with([
            'orders' => Order::with('paymentAttempt')->get()
        ]);
    }

    /**
     * Return a single Resource in a view.
     *
     * @param \App\Order $order
     * @param \App\Billing\PaymentGateway $paymentGateway
     * @return \Illuminate\View\View
     */
    public function show(Order $order, PaymentGateway $paymentGateway)
    {
        if ($order->needsToSyncPayment()){
            try {
                $order->syncPayment($paymentGateway);
                Session::flash('info', 'Orden Refrescada');
            } catch (\Exception $e) {
                Session::flash('info', 'No se pudo refrescar la orden');
            }
        }

        return view('orders.show')->with([
            'order' => $order,
        ]);
    }

    /**
     * Store a new Resource, redirects to the payment.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = request()->validate([
            'email' => 'required|string|email|max:255',
            'method' => 'required|string|in:pse',
            'quantity' => 'required|integer|min:1|max:500'
        ]);

        $order = Order::create([
            'email' => $data['email'],
            'quantity' => $data['quantity'],
            'amount' => $data['quantity'] * PhotoOnSale::price(),
            'description' => PhotoOnSale::description(),
            'reference' => str_random(15),
        ]);

        return redirect()
            ->route("orders.payments.{$data['method']}.create", $order);
    }
}
