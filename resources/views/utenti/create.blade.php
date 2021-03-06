@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'utenti','method'=>'POST'))!!} 
<div class="row">
    <div class="col-xs-4 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('username', Lang::choice('messages.username',0)) !!}
            {!! Form::text('username', '', array('class'=>'form-control','placeholder'=>Lang::choice('messages.username',0))) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('username') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-4 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('username_c', Lang::choice('messages.username_c',0)) !!}
            {!! Form::text('username_c', '', array('class'=>'form-control','placeholder'=>Lang::choice('messages.username',0))) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('username_c') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-4 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('password', Lang::choice('messages.password',0)) !!}
            {!! Form::password('password', array('class'=>'form-control','placeholder'=>'password')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('password') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-4 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('password_c', Lang::choice('messages.password_c',0)) !!}
            {!! Form::password('password_c', array('class'=>'form-control','placeholder'=>'password')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('password_c') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-3 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('ruolo_utente', Lang::choice('messages.ruolo_utente',0)) !!}  
            {!! Form::select('ruolo_utente', array(null => Lang::choice('messages.seleziona_ruolo',0)) + $ruolo, null,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@foreach($errors->get('ruolo_utente') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-5 col-xs-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.crea_utente',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop