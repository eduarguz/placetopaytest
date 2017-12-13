@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="text-center page-header"> Orden de compra <b>#{{$order->reference}}</b></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif


                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Compra de la foto: <i>"{{$order->description}}"</i></p>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <p><b>Email:</b> {{$order->email}}</p>
                            </div>
                            <div class="col-sm-6">
                                <p class=""><b># Referencia:</b> {{$order->reference}} </p>
                                <p class=" text-muted"><b>Creación:</b> {{$order->created_at->toDateString()}}</p>
                                <p class=""><b>Cantidad:</b> {{$order->quantity}}</p>
                                <p class=""><b>Pago:</b> {{$order->formattedAmount()}} COP</p>
                            </div>
                        </div>
                        <p>
                            <b>Estado del pago:</b>
                            @include('orders.payment_attempt.status_label', ['paymentAttempt' => $order->paymentAttempt])
                        </p>
                        <hr>
                        <p class="text-center">
                            @include('orders.partials.options', ['order' => $order])
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if($order->hasPaymentAttempt())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="text-center page-header"> Transacciones realizadas</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Última transacción
                        </div>
                        <div class="panel-body">
                            @include('orders.payment_attempt.show', ['paymentAttempt' => $order->paymentAttempt])
                        </div>
                    </div>

                    @if($order->hasOldPaymentAttempts())
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Transacciónes Anteriores
                            </div>
                            <div class="panel-body">
                                @foreach($order->oldPaymentAttempts() as $paymentAttempt)
                                    @if($loop->iteration > 1)
                                        <hr>
                                    @endif

                                    @include('orders.payment_attempt.show', ['paymentAttempt' => $paymentAttempt])
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection