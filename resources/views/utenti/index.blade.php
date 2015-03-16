@section('content')
<div class="row">
    <div class="col-xs-12">
        <a href="{!!url('/utenti/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuovo_utente',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-12">
        {!! $utenti_lista->links() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-responsive">
            <thead>        
                <tr>
                    <th>{!!Lang::choice('messages.titolo_index_utente_nome',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                </tr>
            </thead>
            @foreach($utenti_lista as $utente)
            <tr> 
                <td>{!!@$utente['username']!!}</td>
                <td>
                    <a href="{!!url('/utenti/'.$utente['id'].'/edit')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_modifica',0)!!}</a>
                    @if ($utente->confermato) 
                        <a href="{!!url('/utenti/'.$utente['id'].'/disable')!!}" class="btn btn-warning">{!!Lang::choice('messages.pulsante_disabilita',0)!!}</a>
                    @else
                        <a href="{!!url('/utenti/'.$utente['id'].'/enable')!!}" class="btn btn-success">{!!Lang::choice('messages.pulsante_abilita',0)!!}</a>
                    @endif                        
                    <a href="{!!url('/utenti/'.$utente['id'])!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                </td>
            </tr> 
            @endforeach      
        </table>
    </div>
</div>

@stop