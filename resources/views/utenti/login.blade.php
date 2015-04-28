@extends('template.front')
@section('content')
<div class="page-header">
    <h2>{!!Lang::choice('messages.login_titolo',0)!!}</h2>
</div>

<div class="col-md-4 col-md-offset-4 col-sm-5 col-xs-12">
    {!! Form::open(array('url' => 'login','method'=>'POST')) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('username', Lang::choice('messages.login_username',0)) !!}
                        {!! Form::email('username', '', array('class'=>'form-control')) !!} 
                    </div>
                </div>
            </div>
            @foreach($errors->get('username') as $message)
            <div class="row">
                <div class="col-xs-12">
                    <p class="bg-danger">{!! $message !!}</p>
                </div>
            </div>
            @endforeach
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('password', Lang::choice('messages.login_password',0)) !!}
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
            @if (Session::has('errore_auth'))
            <div class="row">
                <div class="col-xs-12">
                    <p class="bg-danger">{!! Session::get('errore_auth') !!}</p>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <a href="{!!url('/password/reset')!!}" class="">{!!Lang::choice('messages.login_forget_password',0)!!}</a>
                    </div>
                </div>
            </div>
            @foreach($errors->get('password') as $message)
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <p class="bg-danger">{!! $message !!}</p>
                </div>
            </div>
            @endforeach
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::submit(Lang::choice('messages.login_pulsante',0), array('class' =>'btn btn-success'))!!} 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">{!!Lang::choice('messages.nuovo_utente',0)!!}</div>
                            <div class="panel-body">
                                <a href="/signin">{!!Lang::choice('messages.registrati',0)!!}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::token() !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop