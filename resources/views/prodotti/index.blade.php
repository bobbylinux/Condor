@extends('template.back')
@section('content')
<div class="page-header">
    <h2>{!!Lang::choice('messages.prodotti',0)!!}</h2>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <a href="{!!url('/prodotti/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuovo_prodotto',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-8 col-xs-offset-2">
        {!! $prodotti_lista->render() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-lg-9 col-md-8">{!!Lang::choice('messages.titolo_index_prodotto_nome',0)!!}</th>
                            <th class="col-lg-3 col-md-4">{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
                        </tr>
                    <thead>
                        @foreach($prodotti_lista as $prodotto)
                        <tr> 
                            <td>{!!@$prodotto['titolo']!!}</td>
                            <td>
                                <a href="{!!url('/prodotti/'.$prodotto['id'].'/edit')!!}" class="btn btn-primary">{!!Lang::choice('messages.pulsante_modifica',0)!!}</a>
                                <a href="{!!url('/prodotti/'.$prodotto['id'])!!}" class="btn btn-danger btn-cancella" data-token="<?= csrf_token() ?>">{!!Lang::choice('messages.pulsante_elimina',0)!!}</a>
                            </td>
                        </tr> 
                        @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@stop