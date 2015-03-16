@section('content')
<div class="page-header">
    <h2>Reset Password</h2>
</div>

{!! Form::open(array('url' => 'password/reset','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-4 col-sm-offset-1">
        <div class="form-group">
            {!! Form::label('email', 'Indirizzo email') !!}
            {!! Form::text('username', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('username') as $message)
<div class="row">
    <div class="col-xs-4 col-xs-offset-1">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-4 col-sm-offset-1">
        <div class="form-group">
            {!! Form::submit('Reset', array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop