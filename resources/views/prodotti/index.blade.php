@section('content')
<div class="row">
    <div class="col-xs-12">
        <a href="{!!url('/prodotti/create')!!}" class="btn btn-success">{!!Lang::choice('messages.nuovo_prodotto',0)!!}</a>
    </div>
</div>
<div class='row'>
    <div class="col-xs-12">
        {!! $prodotti_lista->links() !!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>{!!Lang::choice('messages.titolo_index_prodotto_nome',0)!!}</th>
                    <th>{!!Lang::choice('messages.titolo_azioni',0)!!}</th>
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
@stop