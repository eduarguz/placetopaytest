@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <form action="{{route('orders.payments.pse.store', $order)}}" method="POST" class="form-horizontal">
                        <div class="panel-body">
                            <div class="alert alert-info text-center"> Estás a punto de pagar
                                <b>{{ $order->formattedAmount() }} COP</b> con PSE
                            </div>

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Email de la orden:</label>
                                <div class="col-md-6">
                                    <label class="control-label">{{$order->email}}</label>
                                </div>
                            </div>

                            <h3 class="page-header">Información del Comprador</h3>

                            {{-- Name--}}
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="firstName">Nombre:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>

                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--Last Name--}}
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="lastName">Apellidos:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--Document Type--}}
                            <div class="form-group{{ $errors->has('document_type') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="documentType">Tipo de Documento:</label>

                                <div class="col-md-6">
                                    <select name="document_type" id="documentType" class="form-control" required>
                                        <option value="CC">Cédula de ciudadanía colombiana</option>
                                        <option value="CE">Cédula de extranjería</option>
                                        <option value="TI">Tarjeta de identidad</option>
                                        <option value="PPN">Pasaporte</option>
                                        <option value="NIT">Numero de Identificación Tributaria</option>
                                        <option value="SSN">Social Security Number</option>
                                    </select>

                                    @if ($errors->has('document_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('document_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--Last Name--}}
                            <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" for="document">Documento:</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="document" name="document" required>

                                    @if ($errors->has('document'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('document') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <h3 class="page-header">Información del Pago</h3>

                            {{--Person Type--}}
                            <div class="form-group{{ $errors->has('person_type') ? ' has-error' : '' }}">
                                <label for="person_type" class="col-md-4 control-label">Tipo de Persona</label>

                                <div class="col-md-6">
                                    <select name="person_type" id="person_type" class="form-control" required>
                                        <option value="0">Persona Natural</option>
                                        <option value="1">Persona Juridica</option>
                                    </select>

                                    @if ($errors->has('person_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('person_type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            {{--Bank Code--}}
                            <div class="form-group{{ $errors->has('bank_code') ? ' has-error' : '' }}">
                                <label for="bank_code" class="col-md-4 control-label">Pagar con:</label>

                                <div class="col-md-6">
                                    <select name="bank_code" id="bank_code" class="form-control" required>
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->bankCode}}">{{$bank->bankName}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('bank_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bank_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="clearfix">
                                <button type="submit" class="btn btn-primary pull-right">
                                    Siguiente
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection