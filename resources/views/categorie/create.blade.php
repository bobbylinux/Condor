@extends('template.back')
@section('content')
<div class="page-header">
    <h2>{{Lang::choice('messages.nuova_categoria',0)}}</h2>
</div>
{!!Form::open(array('url'=>'categorie','method'=>'POST'))!!}
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('nome_categoria', Lang::choice('messages.nome_categoria',0)) !!}
            {!! Form::text('nome_categoria', '', array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@foreach($errors->get('nome') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{{ $message }}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('descrizione_categoria', Lang::choice('messages.descrizione_categoria',0)) !!}
            {!! Form::textarea('descrizione_categoria', '', array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@foreach($errors->get('descrizione') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{{ $message }}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::label('padre_categoria', Lang::choice('messages.padre_categoria',0)) !!}
            {!! Form::select('padre_categoria', array(null => Lang::choice('messages.seleziona_categoria',0)) + $categorie_padre, null,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@foreach($errors->get('padre') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{{ $message }}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.aggiungi_categoria',0), array('class' =>'btn btn-success'))!!}
        </div>
    </div>
</div>
{!!Form::close()!!}
@stop