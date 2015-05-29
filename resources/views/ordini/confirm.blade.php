@extends('template.back')
@section('content')
{!!Form::open(array('url'=>'order/store','method'=>'POST'))!!}
<div class="row">
    <!-- gestione indirizzo spedizione -->
    <div class="panel panel-default">
      <div class="panel-body">
          <div class="row">
              <div class="col-xs-12">
                <h3>{!!Lang::choice('messages.scegli_indirizzo_ordine',0)!!}</h3>
                <a href="{!!url('/address/create')!!}" class="btn btn-success address-add">{!!Lang::choice('messages.aggiungi_indirizzo_ordine',0)!!}</a>
              </div>
          </div>
          <hr>
          <div class="row address-container">
            @if(!$indirizzi_lista->isEmpty())                  
                @foreach($indirizzi_lista as $indirizzo)
                    <div class="col-xs-12 col-md-3">
                        <div class="panel panel-primary address-list" role="alert">
                            <div class="panel-heading">{!! $indirizzo->cognome . ' ' . $indirizzo->nome !!} <a href="#" class="btn btn-default address-change">{!!Lang::choice('messages.pulsante_cambia',0)!!}</a></div>
                            <div class="panel-body">
                                {!! $indirizzo->indirizzo . ' - ' . $indirizzo->cap !!} <br>
                                {!! $indirizzo->citta . ' - ' . $indirizzo->provincia . ' - ' . $indirizzo->paese !!}
                            </div>
                            {!! Form::hidden('destinatario-item', $indirizzo->id, array('class'=>'form-control destinatario-item')) !!} 
                        </div>
                    </div>   
                @endforeach
            @endif
          </div>
          <div class="row">
            <div class="col-xs-4 address-place"></div>
          </div>
      </div>
    </div>
    <!--fine indirizzi-->
    <!-- gestione metodologia spedizione-->
    @if(!$spedizione_lista->isEmpty())
    <div class="panel panel-default travel-selection">
      <div class="panel-body">
          <div class="row">
            <div class="col-xs-12">
                <h3>{!!Lang::choice('messages.scegli_spedizione_ordine',0)!!}</h3>
                <hr>
            </div>
          </div>
          <div class="row travel-container">
            @foreach($spedizione_lista as $spedizione)
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-primary travel-item" role="alert">
                    <div class="panel-heading">{!!$spedizione->spedizione!!} - {!!$spedizione->prezzo!!} {!! $valuta->simbolo !!} <a href="#" class="btn btn-default travel-change">{!!Lang::choice('messages.pulsante_cambia',0)!!}</a></div>
                    <div class="panel-body">
                        {!!$spedizione->note!!} 
                    </div>
                    <input type="hidden" name="prezzo-spedizione" class="prezzo-spedizione" value="{!!$spedizione->prezzo!!}">
                    {!! Form::hidden('spedizione-item', $spedizione->id, array('class'=>'form-control spedizione-item')) !!} 
                </div>
            </div>
            @endforeach
          </div>
          <div class="row">
            <div class="col-xs-4 travel-place"></div>
          </div>   
      </div>
    </div>
    @endif    
    <!--fine gestione travel-->
    <!--gestione pagamento-->
    @if(!$pagamento_lista->isEmpty())
    <div class="panel panel-default payment-selection">
      <div class="panel-body">
          <div class="row">
            <div class="col-xs-12">
                <h3>{!!Lang::choice('messages.scegli_pagamento_ordine',0)!!}</h3><hr>
                <hr>
            </div>
          </div>
          <div class="row payment-container">
            @foreach($pagamento_lista as $pagamento)
            <div class="col-xs-4">           
                <div class="panel panel-primary payment-item" role="alert">
                    <div class="panel-heading">{!!$pagamento->pagamento!!} <a href="#" class="btn btn-default payment-change">{!!Lang::choice('messages.pulsante_cambia',0)!!}</a></div>
                    <div class="panel-body">
                        {!! $pagamento->note !!}
                    </div>
                    {!! Form::hidden('pagamento-item', $pagamento->id, array('class'=>'form-control pagamento-item')) !!}
                </div> 
            </div>
            @endforeach
          </div>
          <div class="row">
            <div class="col-xs-4 payment-place"></div>
          </div>   
      </div>
    </div>
    <div class="row">
        <div class="col-xs-4 payment-detail">
            <input type="hidden" name="amount" value="{!!$totale_carrello!!}">
            <input type="hidden" name="currency_code" value="{!!$valuta->sigla!!}">
            <input type="hidden" name="lc" value="{!!Session::get('lang','it')!!}">
            <input type="hidden" name="handling" id="handling" value="0">
        </div>
    </div>    
    @endif
    <!--fine pagamento-->
</div> 
<div class="row">
    <div class="col-xs-4">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.conferma_ordine',0), array('class' =>'btn btn-success','id'=>'btn-conferma-ordine'))!!} 
        </div>
    </div>
</div>
{!! Form::hidden('destinatario', '', array('class'=>'form-control','id'=>'destinatario')) !!} 
{!! Form::hidden('spedizione', '', array('class'=>'form-control','id'=>'spedizione')) !!} 
{!! Form::hidden('pagamento', '', array('class'=>'form-control','id'=>'pagamento')) !!} 
<!--</form>-->
{!!Form::close()!!}
@stop
