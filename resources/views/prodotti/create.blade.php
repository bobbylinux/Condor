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
    {!!Form::close()!!}
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
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="crop-avatar">
                            <input type="hidden" value="" class="avatar-view">
                            <!-- Cropping modal -->
                            <div class="modal fade" id="avatar-modal" aria-hidden="true"
                                 aria-labelledby="avatar-modal-label"
                                 role="dialog"
                                 tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form class="avatar-form" action="#" enctype="multipart/form-data"
                                              method="post">
                                            <div class="modal-header">
                                                <button class="close" data-dismiss="modal"
                                                        type="button">&times;</button>
                                                <h4 class="modal-title" id="avatar-modal-label">{!! Lang::choice('messages.carica_immagine',0)!!}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input class="avatar-input" id="avatarInput" name="avatar_file"
                                                       type="file">
                                                <div class="avatar-body">
                                                    <!-- Upload image and data -->
                                                    <div class="avatar-upload">
                                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                                        <input class="avatar-data" name="avatar_data" type="hidden">

                                                    </div>

                                                    <!-- Crop and preview -->
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="avatar-wrapper"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="avatar-preview preview-lg"></div>
                                                            <div class="avatar-preview preview-md"></div>
                                                            <div class="avatar-preview preview-sm"></div>
                                                        </div>
                                                    </div>

                                                    <div class="row avatar-btns">
                                                        <div class="col-md-2">
                                                            <button class="btn btn-primary btn-block avatar-save"
                                                                    data-token="<?php echo csrf_token(); ?>" data-url="{!!url('/immagini')!!}" type="submit">
                                                                {!! Lang::choice('messages.pulsante_conferma',0)!!}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                        </div>
                    </div>
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

@stop

