@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'configurazione/'.$configurazione->id,'method'=>'PUT'))!!} 
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('titolo', Lang::choice('messages.conf_titolo',0)) !!}
            {!! Form::text('titolo', $configurazione->titolo, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('titolo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('logo', Lang::choice('messages.conf_logo',0)) !!}  
            {!! Form::text('logo', $configurazione->logo, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('logo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('sfondo', Lang::choice('messages.conf_sfondo',0)) !!}  
            {!! Form::text('sfondo', $configurazione->sfondo, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('sfondo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('lingua', Lang::choice('messages.conf_lingua',0)) !!}  
            {!! Form::text('lingua', $configurazione->lingua, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('lingua') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.conf_salva',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop