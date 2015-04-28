@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'utenti/'.$utente->id,'method'=>'PUT'))!!} 
<div class="row">
    <div class="col-xs-4 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('username', Lang::choice('messages.username',0)) !!}
            {!! Form::text('username', $utente->username, array('class'=>'form-control','placeholder'=>'indirizzo e-mail')) !!} 
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
    <div class="col-xs-3 col-xs-offset-2">        
        <div class="form-group">            
            {!! Form::label('ruolo_utente', Lang::choice('messages.ruolo_utente',0)) !!}  
            @if ($utente->ruolo !=null)
                {!! Form::select('ruolo_utente', $ruolo, $utente->ruolo,array('class'=>'form-control')) !!} 
            @else
                {!! Form::select('ruolo_utente', array(null => Lang::choice('messages.seleziona_ruolo',0)) + $categorie_padre, null,array('class'=>'form-control')) !!} 
            @endif
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
            {!! Form::submit(Lang::choice('messages.modifica_utente',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
@stop