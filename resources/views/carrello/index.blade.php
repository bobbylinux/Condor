@extends('template.front')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="{!!url('/')!!}">Home</a></li>
            <li class="active">{!!Lang::choice('messages.carrello',0)!!}</li>
        </ol>
    </div>
</div>
@if($carrello_lista != null)
{!!Form::open(array('url'=>'order/confirm','method'=>'POST'))!!} 
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-responsive">
                <thead>
                <th>
                </th>
                <th>
                </th>
                <th>                        
                    {!!Lang::choice('messages.quantita',0)!!}
                </th>
                <th>
                    {!!Lang::choice('messages.prezzo',0)!!}
                </th>
                <th>
                </th>
                </thead>
                <?php
                $id = "";
                $index = 0;
                $totale = 0;
                ?>
                <tbody>
                    @foreach($carrello_lista as $carrello)
                    @if ($id != $carrello->prodotto_id)
                    <tr class="tr-carrello">
                        <td class="col-xs-2">
                            <a href="/catalogo/prodotto/{!!$carrello->prodotto_id!!}">
                                <img class="thumbnail" src="{!!$carrello->immagine_url.'/'.$carrello->immagine_nome!!}" height="100"/>
                            </a>
                        </td>
                        <td class="cart-col-prod col-xs-6">
                            {!!$carrello->prodotto!!}
                        </td>
                        <td class="cart-col-qta col-xs-1">
                            {!! Form::input('number','quantita', $carrello->quantita,array('class'=>'form-control input-small quantita','data-token' => csrf_token() ,'data-id'=>url('/carrello/'.$carrello->id),'data-token'=>csrf_token())) !!}
                        </td>
                        <td class="cart-col-price col-xs-1">
                            {!!number_format((float)$carrello->prezzo*$carrello->quantita, 2, '.', '')!!} {!! $valuta->simbolo !!}                                
                        </td>
                        <td class="cart-col-delete col-xs-1">
                            <a href="{!!url('/carrello/'.$carrello->id)!!}" data-id = "{!!$carrello->id!!}" data-token="<?= csrf_token() ?>" class="btn btn-danger btn-large btn-del-item-cart">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                        </td>
                    </tr>
                    <?php
                    $id = $carrello->prodotto_id;
                    $index +=$carrello->quantita;
                    $totale += $carrello->prezzo * $carrello->quantita;
                    ?>
                    @endif
                    @endforeach
                </tbody>
            </table>       
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-2">
        <div class="form-group">
            {!! Form::submit(Lang::choice('messages.procedi_all_acquisto',0), array('class' =>'btn btn-success'))!!} 
        </div>                
    </div>    
    <div class="col-xs-5 col-sm-offset-5">
        <h4 class="cart-tot-price">{!!Lang::choice('messages.totale_provvisorio',0)!!} ( {!!$index!!}@if($index==1) {!!Lang::choice('messages.articolo',0)!!} @else {!!Lang::choice('messages.articolo',0)!!} @endif): {!!number_format((float)$totale, 2, '.', '')!!} {!! $valuta->simbolo !!}</h4>
    </div>
    <div class="row">

    </div>
    {!!Form::close()!!}
@else

    <div class="panel panel-default">
        <div class="panel-body">
            {!!Lang::choice('messages.carrello_vuoto',0)!!}
        </div>
    </div>
    <a href="/" class="btn btn-success">{!!Lang::choice('messages.ritorna_alla_homepage',0)!!}</a>
@endif
@stop