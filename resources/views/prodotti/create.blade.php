@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'prodotti','method'=>'POST','files' => true ))!!} 
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('codice_prodotto', Lang::choice('messages.codice_prodotto',0)) !!}
            {!! Form::text('codice_prodotto', '', array('class'=>'form-control')) !!} 
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
            {!! Form::text('titolo_prodotto', '', array('class'=>'form-control')) !!} 
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
            {!! Form::textarea('descrizione_prodotto', '', array('class'=>'form-control')) !!} 
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
            {!! Form::text('quantita_prodotto', '', array('class'=>'form-control')) !!} 
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
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('spedizione_prodotto', Lang::choice('messages.spedizione_prodotto',0)) !!}
            {!! Form::select('spedizione_prodotto', array('1' => Lang::choice('messages.si',0),'0'=> Lang::choice('messages.no',0)),'1',array('class'=>'form-control')) !!}
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
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('categoria_prodotto', Lang::choice('messages.categoria_prodotto',0)) !!}
            {!! Form::select('categoria_prodotto', array(null => Lang::choice('messages.seleziona_categoria',0)) + $categorie_lista, null,array('class'=>'form-control')) !!}
        </div>
    </div>
</div>
@foreach($errors->get('categoria') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            {!! Form::label('immagine_prodotto', Lang::choice('messages.immagine_prodotto',0)) !!}  
        <div class="panel panel-default">      
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::file('files', array('class'=>'form-control file-img cropit-image-input')) !!}
                </div>
            </div>
        </div>

    </div>
</div>
@foreach($errors->get('immagine') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.aggiungi_prodotto',0), array('class' =>'btn btn-success'))!!} 
        </div>
    </div>
</div>
{!!Form::close()!!} 

@stop