@extends('template.front')
@section('content')
@if ($errore)    
    <div class="panel panel-danger">
        <div class="panel-heading">{!!$titolo!!}</div>
        <div class="panel-body">
            <p>{!!$conferma!!}</p>
        </div>
    </div>
@else
    @if ($titolo == "Conferma Iscrizione" || $titolo == "Aggiornamento Password") 
        <div class="panel panel-success">
            <div class="panel-heading">{!!$titolo!!}</div>
            <div class="panel-body">
                <p>{!!$conferma!!}</p>            
                <a href="{!!url('/')!!}" class="btn btn-primary">Home Page</a>
            </div>
        </div>
    @endif
    @if ($titolo == "Conferma Reset Password")        
        <div class="row">
            <h2>Inserisci nuova password</h2>
        </div>
        {!! Form::open(array('url' => 'password/update','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-4 col-sm-offset-1">
                <div class="form-group">
                    {!! Form::label('password', 'Inserisci Password') !!}
                    {!! Form::password('password', array('class'=>'form-control')) !!} 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-offset-1">
                <div class="form-group">
                    {!! Form::label('password_c', 'Conferma Password') !!}
                    {!! Form::password('password_c', array('class'=>'form-control')) !!} 
                </div>
            </div>
        </div>
        {!! Form::hidden('username', $username) !!} 
        <div class="row">
            <div class="col-xs-4 col-sm-offset-1">
                <div class="form-group">
                    {!! Form::submit('Conferma', array('class' =>'btn btn-success'))!!} 
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endif
    @if ($titolo == "Mail Reset Password") 
        <div class="panel panel-success">
            <div class="panel-heading">{!!$titolo!!}</div>
            <div class="panel-body">
                <p>{!!$conferma!!}</p>
                <a href="{!!url('/')!!}" class="btn btn-primary">Home Page</a>
            </div>
        </div>
    @endif
@endif
@stop
