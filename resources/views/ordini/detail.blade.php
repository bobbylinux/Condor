@extends('template.blank')
@section('content')
<div class="row">
    <div class='col-xs-12'>                     
        @foreach($lista_ordini as $ordine)
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <h6>
                                    {!!Lang::choice('messages.data_ordine',0)!!} {!!date("d/m/Y H:i",strtotime($ordine->data_ordine))!!}
                                </h6> 
                            </div>
                            <div class="col-xs-2">
                                <h6>
                                    {!!Lang::choice('messages.totale_ordine',0)!!} {!!$ordine->totale_ordine!!} {!! $valuta->simbolo !!}
                                </h6> 
                            </div>
                            <div class="col-xs-3">
                                <h6>
                                    {!!lang::choice('messages.ordine_inviato_a',0)!!} {!!$ordine->destinatario_nome!!}   {!!$ordine->destinatario_cognome!!}
                                </h6> 
                            </div>
                            <div class="col-xs-4">
                                <h6>
                                    {!!Lang::choice('messages.ordine_numero',0)!!} {!!$ordine->codice_ordine!!}
                                </h6> 
                            </div>
                        </div>                                                     
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-success" role="alert">{!!$ordine->stato_ordine!!} {!!Lang::choice('messages.il',0)!!} {!!date("d/m/Y H:i",strtotime($ordine->data_stato_ordine))!!}</div>
                        </div>
                    </div>
                    @foreach($dettaglio_ordini as $dettaglio) 
                    @if ($ordine->codice_ordine == $dettaglio->codice_ordine)
                    <div class="row">
                        <div class="col-xs-4">
                            <img src="{!!url('/'.$dettaglio->immagine_url.'/'.$dettaglio->immagine_nome)!!}" alt="..." class="thumbnail" height="100"/>
                        </div>
                        <div class="col-xs-8">
                            <a href="#">{!!$dettaglio->titolo_prodotto!!}</a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop
