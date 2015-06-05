@extends('template.front')
@section('content')
<div class="page-header">
    <h2>{!!Lang::choice('messages.crea_nuovo_destinatario',0)!!}</h2>
</div>
{!!Form::open(array('url'=>'address/store','method'=>'POST'))!!} 
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('cognome', 'Cognome') !!}
            {!! Form::text('cognome', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('cognome') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('nome', 'Nome') !!}
            {!! Form::text('nome', '', array('class'=>'form-control')) !!} 
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
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('note', 'Note Destinatario') !!}
            {!! Form::text('note', '', array('class'=>'form-control')) !!} 
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
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('indirizzo', 'Indirizzo') !!}
            {!! Form::text('indirizzo', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('indirizzo') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('cap', 'CAP') !!}
            {!! Form::text('cap', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('cap') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('citta', 'Città') !!}
            {!! Form::text('citta', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('citta') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('provincia', 'Provincia') !!}
            {!! Form::text('provincia', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('provincia') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('paese', 'Nazione') !!}
            {!! Form::text('paese', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('paese') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('recapito', 'Recapito') !!}
            {!! Form::text('recapito', '', array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('recapito') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::submit('Conferma', array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop