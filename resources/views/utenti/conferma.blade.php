@extends('template.front')
@section('content')
<div class="col-md-6 col-md-offset-3 col-xs-8">
@if ($errore)    
    <div class="panel panel-danger">
        <div class="panel-heading">{!!$titolo!!}</div>
        <div class="panel-body">
            <p>{!!$conferma!!}</p>
        </div>
    </div>
@else
    <div class="page-header">
        <h2>{!!$titolo!!}</h2>
    </div>
    
    @if ($titolo == Lang::choice('messages.controllo_mail_titolo',0) || $titolo == Lang::choice('messages.conferma_iscrizione_titolo',0) || $titolo == "Aggiornamento Password") 
        <div class="panel panel-success">
            <div class="panel-body">
                <p>{!!$conferma!!}</p>            
                <a href="{!!url('/')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_home_page',0)!!}</a>
            </div>
        </div>
    @endif
    @if ($titolo == "Conferma Reset Password")        
        <div class="row">
            <h2>{!!Lang::choice('messages.inserisci_nuova_password',0)!!}</h2>
        </div>
        {!! Form::open(array('url' => 'password/update','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label('password',Lang::choice('messages.password',0))!!}
                    {!! Form::password('password', array('class'=>'form-control')) !!} 
                </div>
            </div>
        </div>
        @foreach($errors->get('password') as $message)
        <div class="row">
            <div class="col-xs-12">
                <p class="bg-danger">{!! $message !!}</p>
            </div>
        </div>
        @endforeach
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label('password_c', Lang::choice('messages.password_c')) !!}
                    {!! Form::password('password_c', array('class'=>'form-control')) !!} 
                </div>
            </div>
        </div>
        @foreach($errors->get('password_c') as $message)
        <div class="row">
            <div class="col-xs-12">
                <p class="bg-danger">{!! $message !!}</p>
            </div>
        </div>
        @endforeach
        {!! Form::hidden('username', $username) !!} 
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::submit(Lang::choice('messages.pulsante_conferma',0), array('class' =>'btn btn-success'))!!} 
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endif
    @if ($titolo == "Mail Reset Password") 
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{!!$conferma!!}</p>
                <a href="{!!url('/')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_home_page',0)!!}</a>
            </div>
        </div>
    @endif
@endif
</div>
@stop
