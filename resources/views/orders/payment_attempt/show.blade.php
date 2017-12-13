<div class="row">
    <div class="col-sm-6">
        <p>
            <b>Transacción:</b> {{ $paymentAttempt->response_body['transactionID'] }}
        </p>
        <p>
            <b>Estado:</b>
            @include('orders.payment_attempt.status_label')
        </p>
    </div>
    <div class="col-sm-6">
        <p><b>Fecha:</b> {{$paymentAttempt->bank_date}}</p>
    </div>
</div>
<p class="text-center">
    <i> "{{ $paymentAttempt->response_body['responseReasonText'] }}"</i>
</p>

