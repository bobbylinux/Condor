@section('content')
<div class="row">
    <div class="col-xs-2">
        <a href="{!!url('/pagamenti/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuovo_metodo_pagamento',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-12">
        {!! $pagamenti_lista->links() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-responsive">
            <thead>        
                <tr>
                    <th>{!!Lang::choice('messages.titolo_index_pagamento_nome',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                </tr>
            </thead>
            @foreach($pagamenti_lista as $pagamento)
            <tr> 
                <td>{!!$pagamento['pagamento']!!}</td>
                <td>
                    <a href="{!!url('/pagamenti/'.$pagamento['id'].'/edit')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_modifica',0)!!}</a>
                    <a href="{!!url('/pagamenti/'.$pagamento['id'])!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                </td>
            </tr> 
            @endforeach      
        </table>
    </div>
</div>

@stop