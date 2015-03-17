@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'valute/'.$valuta->id,'method'=>'PUT'))!!} 
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('nome_valuta',  Lang::choice('messages.nome_valuta',0)) !!}
            {!! Form::text('nome_valuta', $valuta->nome, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('nome') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('simbolo_valuta',  Lang::choice('messages.simbolo_valuta',0)) !!}
            {!! Form::text('simbolo_valuta', $valuta->simbolo, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('simbolo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('sigla_valuta',  Lang::choice('messages.sigla_valuta',0)) !!}
            {!! Form::text('sigla_valuta', $valuta->sigla, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('sigla') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-9 col-sm-offset-1">
        <div class="form-group">
            {!! Form::submit( Lang::choice('messages.modifica_valuta',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop