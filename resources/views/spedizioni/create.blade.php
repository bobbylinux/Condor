@extends('template.back')
@section('content')
<div class="page-header">
    <h2>{!!Lang::choice('messages.nuova_metodologia_spedizione',0)!!}</h2>
</div>
{!!Form::open(array('url'=>'spedizioni','method'=>'POST'))!!} 
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('nome_spedizione', Lang::choice('messages.nome_spedizione',0)) !!}
            {!! Form::text('nome_spedizione', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('spedizione') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('note_spedizione', Lang::choice('messages.note_spedizione',0)) !!}
            {!! Form::textarea('note_spedizione', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('note') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-2 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('prezzo_spedizione', Lang::choice('messages.prezzo_spedizione',0) ) !!}
            {!! Form::text('prezzo_spedizione', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('prezzo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-sm-6 col-sm-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.aggiungi_spedizione',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop