@extends('template.back')
@section('content')
<div class="page-header">
    <h2>{!!Lang::choice('messages.nome_spedizione',0)!!}</h2>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <a href="{!!url('/spedizioni/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuova_metodologia_spedizione',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-8 col-xs-offset-2">
        {!! $spedizioni_lista->render() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>        
                        <tr>
                            <th class="col-lg-9 col-md-8">{!!Lang::choice('messages.titolo_index_spedizione_nome',0)!!}</th>
                            <th class="col-lg-3 col-md-4">{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                        </tr>
                    </thead>
                    @foreach($spedizioni_lista as $spedizione)
                    <tr> 
                        <td>{!!$spedizione['spedizione']!!}</td>
                        <td>
                            <a href="{!!url('/spedizioni/'.$spedizione['id'].'/edit')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_modifica',0)!!}</a>
                            <a href="{!!'/spedizioni/'.$spedizione['id']!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                        </td>
                    </tr> 
                    @endforeach      
                </table>
            </div>
        </div>
    </div>
</div>
@stop