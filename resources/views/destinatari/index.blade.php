@extends('template.front')
@section('content')
<div class="page-header">
    <h2>{!!Lang::choice('messages.miei_dati',0)!!}</h2>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <a href="{!!url('/destinatari/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuovo_indirizzo',0)!!}</a>
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>        
                        <tr>
                            <th class="col-lg-9 col-md-8">{!!Lang::choice('messages.titolo_index_indirizzo_nome',0)!!}</th>
                            <th class="col-lg-3 col-md-4">{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                        </tr>
                    </thead>
                    @foreach($destinatari_lista as $destinatari)
                    <tr> 
                        <td>{!! $destinatari->cognome . ' ' . $destinatari->nome . ' ' . $destinatari->indirizzo . ' - ' . $destinatari->citta . ' - ' . $destinatari->provincia !!}</td>
                        <td>
                            <a href="{!!url('/destinatari/'.$destinatari->id.'/edit')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_modifica',0)!!}</a>
                            <a href="{!!url('/destinatari/'.$destinatari->id)!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                        </td>
                    </tr> 
                    @endforeach      
                </table>
            </div>
        </div>
    </div>
</div>
@stop