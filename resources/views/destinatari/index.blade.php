@section('content')
<div class="row">
    <div class="col-xs-12">
        <h2>Scegli un indirizzo al quale spedire il tuo ordine</h2>
    </div>
</div>
@if(!$indirizzi_lista->isEmpty())
    @foreach($indirizzi_lista as $indirizzo)
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-success address-list" role="alert">
                {!! $indirizzo->cognome . ' ' . $indirizzo->nome !!} <br>
                {!! $indirizzo->indirizzo . ' - ' . $indirizzo->cap !!} <br>
                {!! $indirizzo->citta . ' - ' . $indirizzo->provincia . ' - ' . $indirizzo->paese !!}
            </div>
        </div>
    </div>
    @endforeach
@endif
<div class="row">
    <div class="col-xs-12">
        <a href="{!!url('/address/create')!!}" class="btn btn-success address-add">Aggiungi Indirizzo di Spedizione</a>
    </div>
</div>
</div>
@stop
