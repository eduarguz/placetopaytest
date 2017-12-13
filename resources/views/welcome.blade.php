@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Pagar</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('pending-orders.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                <label for="quantity" class="col-md-4 control-label">Cantidad a pagar (COP):</label>

                                <div class="col-md-6">
                                    <input class="form-control"
                                           id="quantity"
                                           value="{{ old('quantity')?: 40580}}"
                                           type="number"
                                           min="1000"
                                           name="quantity"
                                           required
                                           autofocus
                                    >

                                    @if ($errors->has('quantity'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="method" class="col-md-4 control-label">Método de Pago:</label>
                                <div class="col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="method" id="pse" value="pse" checked>
                                            Pagar Usando PSE
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="text-muted">
                                            <input type="radio" name="method" id="pse" value="cc" disabled>
                                            <del>Pagar con Tarjeta de crédito</del>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label class="text-muted">
                                            <input type="radio" name="method" id="pse" value="cash" disabled>
                                            <del>Pagar en Efectivo</del>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Pagar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection