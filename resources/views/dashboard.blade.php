@section('content')
<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.categorie',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/categorie/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/categorie')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.prodotti',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/prodotti/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/prodotti')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div> 
    @if (Auth::user()->ruolo == 3)
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.valute',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/valute/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/valute')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div>
    @endif
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.listini_prezzo',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/listini/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/listini')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.metodi_pagamento',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/pagamenti/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/pagamenti')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div><div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.metodi_spedizione',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/spedizioni/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/spedizioni')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.utenti',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/utenti/create')!!}">{!!Lang::choice('messages.crea_nuova',0)!!}</a></p>
                <p><a href="{!!url('/utenti')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div> 
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading dash-head">{!!Lang::choice('messages.ordini',0)!!}</div>
            <div class="panel-body dash-detail">
                <p><a href="{!!url('/ordini')!!}">{!!Lang::choice('messages.gestisci',0)!!}</a></p>
            </div>
        </div>
    </div>
</div>


@stop