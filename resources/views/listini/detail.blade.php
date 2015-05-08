@extends('template.back')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <ol class="breadcrumb">
            <li><h4>{!! $listino_master->nome !!}</h4></li>
        </ol>
    </div>
</div>
{!! Form::open(array('url' => '', 'method' => 'POST')) !!}
<div class="row">
    <div class="col-xs-12">
        <table class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th>{!!Lang::choice('messages.codice_listino',0)!!}</th>
                    <th>{!!Lang::choice('messages.data_inizio_validita',0)!!}</th>
                    <th>{!!Lang::choice('messages.data_fine_validita',0)!!}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{!! $listino_master->codice !!}</td>
                    <td>{!! date("d-m-Y",strtotime($listino_master->data_inizio)) !!}</td>
                    <td>{!! date("d-m-Y",strtotime($listino_master->data_fine)) !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <ol class="breadcrumb">
            <li><h4>{!!Lang::choice('messages.inserisci_prodotto',0)!!}</h4></li>
        </ol>
    </div>
</div>
<div class='row'>
    <div class="col-xs-4">  
        <div class="form-group">    
            <div class="input-group">
                {!! Form::text('codice', '', array('placeholder'=>Lang::choice('messages.codice_dettaglio',0), 'class'=>'form-control','id'=>'codice','data-token'=> csrf_token())) !!}            
                <span class="input-group-btn">
                    <button class="btn btn-default btn-search" id="search-code" type="button">{!!Lang::choice('messages.pulsante_cerca',0)!!}</button>
                </span>
            </div><!-- /input-group -->
        </div>
    </div><!-- /.col-lg-6 -->
</div>
<div class="row">
    <div class="col-xs-9">
        <div class="form-group">
            <div class="input-group">
                {!! Form::text('titolo', '', array('placeholder'=>Lang::choice('messages.titolo_dettaglio',0),'class'=>'form-control','id'=>'titolo','data-token'=> csrf_token())) !!} 
                <span class="input-group-btn">
                    <button class="btn btn-default btn-search" id="search-title" type="button">{!!Lang::choice('messages.pulsante_cerca',0)!!}</button>
                </span>
            </div>
        </div>
        {!!      Form::hidden('prodotto','',array('id'=>'id-prodotto'))!!} 
        {!!	Form::hidden('listino',$listino_master->id,array('id'=>'id-listino'))!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <div class="form-group">
            {!! Form::input('number','prezzo', '',array('placeholder'=>Lang::choice('messages.prezzo_dettaglio',0),'class'=>'form-control input-small','id'=>'prezzo')) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <div class="form-group">
            {!! Form::input('number','sconto', '',array('placeholder'=>Lang::choice('messages.sconto_dettaglio',0),'class'=>'form-control input-small','id'=>'sconto')) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.pulsante_aggiungi',0), array('class'=>'btn btn-success btn-large','id'=>'btn-aggiungi-prodotto','data-token'=> csrf_token())) !!}
            <a href="{!!url('/listini')!!}" id="btn-termina-detail" class="btn btn-primary btn-large">{!!Lang::choice('messages.pulsante_termina',0)!!}</a>            
            <button class="btn btn-default btn-reset" id="" type="button">{!!Lang::choice('messages.pulsante_ripristina',0)!!}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}
<div class="row">
    <div class="col-xs-12">
        <ol class="breadcrumb">
            <li><h4>{!!Lang::choice('messages.prodotti_listino',0) . ' ' . $listino_master->nome !!}</h4></li>
        </ol>
    </div>
    <div class="col-xs-12">
        <table class="table table-hover" id="tabella-prodotti-listino">
            <thead>
                <tr>
                    <th>{!!Lang::choice('messages.numero_dettaglio',0)!!}</th>
                    <th>{!!Lang::choice('messages.codice_dettaglio',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_dettaglio',0)!!}</th>
                    <th>{!!Lang::choice('messages.prezzo_dettaglio',0)!!}</th>
                    <th>{!!Lang::choice('messages.sconto_dettaglio',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $idx = 1; ?>
                @foreach($listino_detail as $prodotto)
                <tr>
                    <td>{!! $idx !!}</td>
                    <td class="detail-code">{!! $prodotto->codice !!}</td>
                    <td class="detail-name">{!! $prodotto->titolo !!}</td>
                    <td class="detail-price">{!! number_format((float)$prodotto->prezzo, 2, '.', '') !!}</td>
                    <td class="detail-discount">{!! $prodotto->sconto !!}</td>
                    <td><a href="" data-detail="{!! $prodotto->listini_id !!}" class="btn btn-primary btn-edit-list-prod">{!! Lang::choice('messages.pulsante_modifica',0) !!}</a></td>
                    <td><a href="{!!url('listini/'.$listino_master->id.'/detail/'.$prodotto->listini_id)!!}" data-token="<?= csrf_token() ?>" class="btn btn-danger btn-cancella">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a></td>
                </tr>
                <?php $idx++; ?>
                @endforeach		
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="lista-prodotti" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{!!Lang::choice('messages.seleziona_un_prodotto',0)!!}</h4>
            </div>
            <div class="modal-body">
                <table id="tabella-lista-prodotti" class="table">
                    <thead>
                        <tr class="success">
                            <td>{!!Lang::choice('messages.codice_prodotto',0)!!}</td>

                            <td>{!!Lang::choice('messages.nome_prodotto',0)!!}</td>
                        </tr>
                    </thead>
                    <tbody id="tbody-lista-prodotti"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!Lang::choice('messages.pulsante_annulla',0)!!}</button>
                <button type="button" id="btn-inserisci-prodotto"
                        class="btn btn-primary">{!!Lang::choice('messages.pulsante_seleziona',0)!!}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="msg-product">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">{!!Lang::choice('messages.pulsante_chiudi',0)!!}</span></button>
                <h6 class="modal-title" id="modifica-titolo">{!!Lang::choice('messages.titolo_index_prodotto_nome',0)!!}</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            {!! Form::label('Prezzo Unitario', Lang::choice('messages.prezzo_dettaglio',0)) !!} 
                            {!! Form::input('number','prezzo', '',array('class'=>'form-control input-small','id'=>'modifica-prezzo')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            {!! Form::label('sconto', Lang::choice('messages.sconto_dettaglio',0) . ' (%)') !!} 
                            {!! Form::input('number','sconto', '',array('class'=>'form-control input-small','id'=>'modifica-sconto')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-annulla-prod">{!!Lang::choice('messages.pulsante_annulla',0)!!}</button>
                <a  class="btn btn-success" id="btn-conferma-prod" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_conferma',0)!!}</a>
                <input type="hidden" value="" id="modifica-id"/>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
