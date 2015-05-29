@extends('template.front')
@section('content')
    {!!Form::open(array("url" => "https://www.sandbox.paypal.com/cgi-bin/webscr","method"=>"POST"))!!}

    <div class="row">
        <div class="panel panel-success address-list" role="alert">
            <div class="panel-body">
                {!!Lang::choice('messages.ordine_confermato',0)!!} {!!$item_number!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.paga_ordine',0), array('class' =>'btn btn-success'))!!}
        </div>
    </div>
    {!! Form::hidden('cmd', $cmd) !!}
    {!! Form::hidden('amount', $amount) !!}
    {!! Form::hidden('currency_code', $currency_code) !!}
    {!! Form::hidden('buyer_email', $buyer_email) !!}
    {!! Form::hidden('cancel_return', $cancel_return) !!}
    {!! Form::hidden('return', url()) !!}
    {!! Form::hidden('lc', $lc) !!}
    {!! Form::hidden('item_name', $item_name) !!}
    {!! Form::hidden('item_number', $item_number) !!}
    {!! Form::hidden('handling', $handling) !!}
    {!! Form::hidden('business', $business) !!}
    {!! Form::hidden('shipping', $shipping) !!}
    {!!Form::close()!!}
@stop