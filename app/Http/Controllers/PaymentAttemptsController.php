<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Billing\TransactionRequest;
use App\Order;
use App\PaymentAttempt;
use Illuminate\Http\Request;

class PaymentAttemptsController extends Controller
{
    public $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function create(Order $order)
    {
        if ($order->isApproved() || $order->isPending()){
            return redirect(route('orders.show', $order));
        }

        return view('payment-attempts.pse.create')->with([
            'order' => $order,
            'banks' => $this->paymentGateway->getBankList()
        ]);
    }

    public function store(Order $order, Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'document_type' => 'required|string|in:CC,CE,TI,PPN,NIT,SSN',
            'document' => 'required|numeric',
            'person_type' => 'required|in:0,1',
            'bank_code' => 'required|numeric|min:1',
        ]);

        $transaction = TransactionRequest::fromOrder($order, $request);
        $transaction->returnURL = route('orders.show', $order);

        $response = $this->paymentGateway->createTransaction($transaction);

        $paymentAttempt = PaymentAttempt::create([
            'order_id' => $order->id,
            'status' => $response->responseCode,
            'transaction_id' => $response->transactionID,
            'response_body' => $response
        ]);

        if ($paymentAttempt->isPending()){
            return redirect($response->bankURL);
        }

        return redirect(route('orders.show', $order));
    }

}
