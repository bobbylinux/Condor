@extends('template.front')
@section('content')
<div class="page-header">
    <h2>Reset Password</h2>
</div>

<div class="col-md-4 col-md-offset-4 col-xs-8">
    {!! Form::open(array('url' => 'password/reset','method'=>'POST')) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('email', 'Indirizzo email') !!}
                        {!! Form::text('username', '', array('class'=>'form-control')) !!} 
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
                        {!! Form::submit('Reset', array('class' =>'btn btn-success'))!!} 
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop