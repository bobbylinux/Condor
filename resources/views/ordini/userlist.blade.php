@section('content')
<div class="row">
    <div class='col-xs-12'>
        <h3>{!!Lang::choice('messages.miei_ordini_titolo',0)!!}</h3><hr>
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a class="tab-ordini-cliente" href="#totali" aria-controls="totali" role="tab" data-toggle="tab">{!!Lang::choice('messages.ordini',0)!!}</a></li>
                <li role="presentation"><a class="tab-ordini-cliente" href="#incorso" aria-controls="incorso" role="tab" data-toggle="tab">{!!Lang::choice('messages.ordini_in_corso',0)!!}</a></li>
                <li role="presentation"><a class="tab-ordini-cliente" href="#cancellati" aria-controls="cancellati" role="tab" data-toggle="tab">{!!Lang::choice('messages.ordini_cancellati',0)!!}</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="totali">
                    <div class="row">
                        <div class="col-xs-12">
                            <h6>{!!count($lista_ordini)!!} @if(count($lista_ordini) == 1) {!!Lang::choice('messages.ordine_effettuato',0)!!} @else {!!Lang::choice('messages.ordini_effettuati',0)!!}@endif</h6>
                        </div>
                    </div>
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
                                        <div class="col-xs-2">
                                            <a href="#" class="btn btn-danger">{!!Lang::choice('messages.annulla_ordine',0)!!}</a>
                                        </div>
                                        <div class="col-xs-2">
                                            <h6>
                                                {!!Lang::choice('messages.ordine_numero',0)!!} {!!$ordine->codice_ordine!!}
                                                <a href="#">{!!Lang::choice('messages.stampa_riepilogo_ordine',0)!!}</a>
                                            </h6> 
                                        </div>
                                    </div>                                                     
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="alert alert-success" role="alert">{!!$ordine->stato_ordine!!} {!!Lang::choice('messages.il',0)!!} {!!date("d/m/Y H:i",strtotime($ordine->data_stato_ordine))!!}</div>
                                        </div>
                                    </div>
                                    @foreach($dettaglio_ordini as $dettaglio) 
                                        @if ($ordine->codice_ordine == $dettaglio->codice_ordine)
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <img src="{!!url('/'.$dettaglio->immagine_url.'/'.$dettaglio->immagine_nome)!!}" alt="..." class="thumbnail" height="100"/>
                                            </div>
                                            <div class="col-xs-6">
                                                <a href="#">{!!$dettaglio->titolo_prodotto!!}</a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div role="tabpanel" class="tab-pane" id="incorso">Ordini ancora in corso</div>
                <div role="tabpanel" class="tab-pane" id="cancellati">Ordini cancellati</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop