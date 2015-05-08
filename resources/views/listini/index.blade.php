@extends('template.back')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <a href="{!!url('/listini/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuovo_listino',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-12">
        {!! $listino_lista->render() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{!!Lang::choice('messages.titolo_index_listino_nome',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                </tr>
            <thead>
                @foreach($listino_lista as $listino)
                <tr> 
                    <td>{!!@$listino['nome']!!}</td>
                    <td>
                        <a href="{!!url('/listini/'.$listino['id'].'/detail')!!}" class="btn btn-warning">{!!Lang::choice('messages.pulsante_dettaglio',0)!!}</a>
                        <a href="{!!url('/listini/'.$listino['id'].'/edit')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_modifica',0)!!}</a>
                        <a href="{!!url('/listini/'.$listino['id'])!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                    </td>
                </tr> 
                @endforeach
        </table>
    </div>
</div>
@stop