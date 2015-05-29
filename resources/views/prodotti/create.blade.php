@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'prodotti','method'=>'POST','files' => true,'id'=>'form-prodotto' ))!!}
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
    <div class="col-xs-12 col-sm-4 col-sm-offset-2">
        <div class="form-group">
            {!! Form::label('tag_prodotto', Lang::choice('messages.tag_prodotto',0)) !!}
            <div class="input-group">
                {!! Form::text('tag_prodotto', '', array('class'=>'form-control','id'=>'tag-input')) !!}
                <span class="input-group-addon btn btn-default" id="add-tag">{!!Lang::choice('messages.aggiungi_tag_prodotto',0)!!}</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2" >
        <div class="panel panel-default">
            <div class="panel-body" id="tag-container">
                
            </div>
        </div>
    </div>
</div>
@foreach($errors->get('tag') as $message)
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
            {!! Form::select('spedizione_prodotto', array('1' => Lang::choice('messages.si',0),'0'=>
            Lang::choice('messages.no',0)),'1',array('class'=>'form-control')) !!}
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
            {!! Form::select('categoria_prodotto', array(null => Lang::choice('messages.seleziona_categoria',0)) +
            $categorie_lista, null,array('class'=>'form-control')) !!}
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
@foreach($errors->get('immagine') as $message)
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <p class="bg-danger">{!! $message !!}</p>
    </div>
</div>
@endforeach
<div class="row">
    <div class="col-xs-12 col-sm-2 col-sm-offset-2">
        {!! Form::label('immagini_prodotto', Lang::choice('messages.immagine_prodotto',0)) !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            <div class="crop-avatar">
                {!! Form::submit(Lang::choice('messages.pulsante_aggiungi_immagine',0), array('class' =>'btn
                btn-primary btn-add-img'))!!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="input-img-div" >
            <input type="file" name="input-img" id="input-img" data-url="{!!url('/immagini')!!}" data-token="{!!  csrf_token() !!}">
        </div>
        <div class="panel panel-default">
            <div class="panel-body">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.aggiungi_prodotto',0), array('class' =>'btn btn-success'))!!}
        </div>
    </div>
</div>
{!!Form::close()!!}
<!-- Cropping modal -->
<div class="modal fade" id="avatar-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">{!!Lang::choice('messages.carica_immagine',0)!!}</h4>
            </div>
            <div class="modal-body">
                <div class="container">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-annulla">{!!Lang::choice('messages.pulsante_annulla',0)!!}</button>
                <button type="button" class="btn btn-primary" id="btn-conferma">{!!Lang::choice('messages.pulsante_conferma',0)!!}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Cropping modal-->
@stop

