@extends('template.back')
@section('content')
<div class="row">
    <table class="table">
        <thead>        
            <tr>
                <th>{!!Lang::choice('messages.ordine_numero',0)!!}</th>
                <th>{!!Lang::choice('messages.utente',0)!!}</th>
                <th>{!!Lang::choice('messages.data_creazione',0)!!}</th>                
                <th>{!!Lang::choice('messages.totale_ordine',0)!!}</th>           
                <th>{!!Lang::choice('messages.pagato_ordine',0)!!}</th>      
                <th>{!!Lang::choice('messages.stato_ordine',0)!!}</th>       
                <th>{!!Lang::choice('messages.data_stato_ordine',0)!!}</th>      
                <th>{!!Lang::choice('messages.codice_tracking',0)!!}</th>      
                <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
            </tr>
        </thead>
        @foreach($ordini_lista as $ordine)
        <tr> 
            <td>{!!$ordine->codice_ordine!!}</td>
            <td>{!!$ordine->nome_utente!!}</td>
            <td>{!!date("d/m/Y H:i",strtotime($ordine->data_ordine))!!}</td>
            <td>{!!$ordine->totale_ordine!!} {!!$valuta->simbolo!!}</td>
            @if ($ordine->pagato) 
            <td><a href="{!!url('/ordini/'.$ordine->id.'/pagato/')!!}" class="btn btn-pagato btn-success" data-order="{!!$ordine->codice_ordine!!}">{!!Lang::choice('messages.si',0)!!}</a></td>
            @else
            <td><a href="{!!url('/ordini/'.$ordine->id.'/pagato/')!!}" class="btn btn-pagato btn-danger" data-order="{!!$ordine->codice_ordine!!}">{!!Lang::choice('messages.no',0)!!}</a></td>
            @endif
            <td><strong>{!!strtoupper($ordine->stato_ordine) !!}</strong></td>
            <td>{!!date("d/m/Y H:i",strtotime($ordine->data_stato_ordine))!!}</td>
            <td>{!!$ordine->tracking_ordine!!}</td>
            <td>
                <a href="{!!url('/ordini/'.$ordine->id.'/detail')!!}" data-token="<?= csrf_token() ?>" class="btn btn-order-detail btn-primary">{!!Lang::choice('messages.pulsante_dettaglio',0)!!}</a>
                <a href="{!!url('/ordini/'.$ordine->id.'/update')!!}" class="btn btn-aggiorna-ordine btn-success" data-token="<?= csrf_token() ?>" data-aggiorna="{!!url('/ordini/'.$ordine->id.'/update/stato/')!!}">{!!Lang::choice('messages.pulsante_aggiorna',0)!!}</a>
                <a href="{!!url('/ordini/'.$ordine->id)!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
            </td>
        </tr> 
        @endforeach      
    </table>
</div>
<!-- Modal Detail -->
<div class="modal fade" id="dettaglio-ordine" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{!!Lang::choice('messages.titolo_dettaglio_ordini',0)!!}</h4>
            </div>
            <div class="modal-body" id="dettaglio-ordine-body">

            </div>
            <div class="modal-footer">
                <button type="button" id="btn-annulla-ordine" class="btn btn-danger">{!!Lang::choice('messages.annulla_ordine',0)!!}</button>
                <button type="button" id="btn-chiudi-dettaglio" class="btn btn-primary">{!!Lang::choice('messages.pulsante_chiudi',0)!!}</button>
            </div>
        </div>
    </div>
</div>
<!--Modal-->
<!-- Modal Aggiorna -->
<div class="modal fade" id="aggiorna-ordine" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="msg-aggiorna">
        <div class="modal-content" id="msg-aggiorna-content">

        </div>
    </div>
</div>
<!--Modal-->
<div class="modal fade" id="msg-pagamento">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">{!!Lang::choice('messages.modale_titolo',0)!!}</h4>
            </div>
            <div class="modal-body">
                <p>{!!Lang::choice('messages.conferma_pagamento',0)!!} <strong id="pagamento-ordine-n"></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-annulla-pagamento">{!!Lang::choice('messages.pulsante_annulla',0)!!}</button>
                <button type="button" class="btn btn-success" data-token ="<?= csrf_token()?>" id="btn-conferma-pagamento">{!!Lang::choice('messages.pulsante_conferma',0)!!}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop