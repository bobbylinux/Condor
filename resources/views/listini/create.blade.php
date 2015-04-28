@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'listini','method'=>'POST'))!!} 
<div class="row">
    <div class="col-xs-12 col-sm-3 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('codice_listino', Lang::choice('messages.codice_listino',0)) !!}
            {!! Form::text('codice_listino', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('codice') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('nome_listino', Lang::choice('messages.nome_listino',0)) !!}
            {!! Form::text('nome_listino', '', array('class'=>'form-control')) !!} 
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
    <div class="col-xs-12 col-sm-3 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('data_inizio', Lang::choice('messages.data_inizio_validita',0)) !!}
            {!! Form::text('data_inizio', '', array('class'=>'form-control datepicker','id'=>'data-inizio')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('data_inizio') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-3 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('data_fine', Lang::choice('messages.data_fine_validita',0)) !!}
            {!! Form::text('data_fine', '', array('class'=>'form-control datepicker','id'=>'data-fine')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('data_fine') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::submit('Aggiungi questo listino', array('class'=>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop