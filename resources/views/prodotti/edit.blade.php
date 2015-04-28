@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'prodotti/'.$prodotto->id,'method'=>'PUT'))!!} 
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('codice_prodotto', Lang::choice('messages.codice_prodotto',0)) !!}
            {!! Form::text('codice_prodotto', $prodotto->codice, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('codice') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('titolo_prodotto', Lang::choice('messages.nome_prodotto',0)) !!}
            {!! Form::text('titolo_prodotto', $prodotto->titolo, array('class'=>'form-control')) !!} 
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
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('descrizione_prodotto', Lang::choice('messages.descrizione_prodotto',0)) !!}
            {!! Form::textarea('descrizione_prodotto', $prodotto->descrizione, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('descrizione') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-2 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('quantita_prodotto', Lang::choice('messages.quantita_prodotto',0)) !!}
            {!! Form::text('quantita_prodotto', $prodotto->quantita, array('class'=>'form-control')) !!} 
        </div>
    </div>
</div>
@foreach($errors->get('quantita') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<?php 
if(!$prodotto->spedizione) {
    $spedizione = 0; 
} else {
    $spedizione = 1; 
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('spedizione_prodotto', Lang::choice('messages.spedizione_prodotto',0)) !!}
            {!! Form::select('spedizione_prodotto', array(true => Lang::choice('messages.si',0),false=> Lang::choice('messages.no',0)),$spedizione,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@foreach($errors->get('spedizione_prodotto') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
@foreach($categorie as $categoria)
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('categoria_prodotto', Lang::choice('messages.categoria_prodotto',0)) !!}
            {!! Form::select('categoria_prodotto', $categorie_lista, $categoria->categoria,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@endforeach
@foreach($errors->get('categoria') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.modifica_prodotto',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 
@stop